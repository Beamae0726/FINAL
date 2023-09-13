<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ArticleCollection;
use App\Models\ReliableSource;



use Phpml\Classification\NaiveBayes;
use Phpml\FeatureExtraction\TokenCountVectorizer;
use Phpml\Tokenization\WhitespaceTokenizer;


class ChatBotController extends Controller
{
   

    
    public function index()
    {
        return view('chatbot');
       
    }
    public function ask(Request $request)
    {
        $keyword = $request->input('question');
    
        // Check if the keyword is a greeting
        $greetingsFile = public_path('greetings.csv');
        $response = '';
    
        if (file_exists($greetingsFile)) {
            $greetings = array_map('str_getcsv', file($greetingsFile));
    
            foreach ($greetings as $greeting) {
                if (stripos($keyword, $greeting[0]) !== false) {
                    $response = $greeting[1];
                    break;
                }
            }
        }
    
        if (empty($response)) {
            // Search in ArticleCollection model
            $articles = ArticleCollection::where('title', 'LIKE', "%{$keyword}%")
                ->orWhere('details', 'LIKE', "%{$keyword}%")
                ->get();
    
            // Search in ReliableSource model
            $reliableSources = ReliableSource::where('name', 'LIKE', "%{$keyword}%")
                ->get();
    
            // Check if any articles or reliable sources match the filter
            if ($articles->isEmpty() && $reliableSources->isEmpty()) {
                return response()->json([
                    'message' => 'Fake'
                ]);
            }
    
            // Combine text data from articles and reliable sources
            $textData = $articles->pluck('title')->concat($articles->pluck('details'))
                ->concat($reliableSources->pluck('name'));
    
            // Prepare training data dynamically from CSV files
            $relevantSamples = $this->readTrainingDataFromCSV(public_path('relevant_samples.csv'));
            $nonRelevantSamples = $this->readTrainingDataFromCSV(public_path('non_relevant_samples.csv'));
    
            $trainingSamples = array_merge($relevantSamples, $nonRelevantSamples);
            $trainingLabels = array_merge(
                array_fill(0, count($relevantSamples), 1), // Relevant label (1)
                array_fill(0, count($nonRelevantSamples), 0) // Non-relevant label (0)
            );
    
            // Train the Naive Bayes classifier
            $vectorizer = new TokenCountVectorizer(new WhitespaceTokenizer());
            $vectorizer->fit($trainingSamples);
            $vectorizer->transform($trainingSamples);
    
            $classifier = new NaiveBayes();
            $classifier->train($trainingSamples, $trainingLabels);
    
            // Prepare testing data
            $testingSamples = $textData->toArray();
    
            // Perform classification on testing data
            $vectorizer->transform($testingSamples);
            $predictions = $classifier->predict($testingSamples);
    
            // Separate the predictions for articles and reliable sources
            $articlePredictions = array_slice($predictions, 0, $articles->count());
            $reliableSourcePredictions = array_slice($predictions, $articles->count());
    
            // Articles and/or reliable sources found
            return response()->json([
                'message' => 'Real',
                'articles' => $articles,
                'reliable_sources' => $reliableSources,
                'article_predictions' => $articlePredictions,
                'reliable_source_predictions' => $reliableSourcePredictions
            ]);
        }
    
        // Return the response for greetings
        return response()->json(['message' => $response]);
    }
    
    
    private function readTrainingDataFromCSV($csvFilePath)
    {
        $samples = [];
    
        if (($handle = fopen($csvFilePath, "r")) !== false) {
            while (($data = fgetcsv($handle)) !== false) {
                // Assuming the text data is in the first column of the CSV file
                $sample = $data[0];
                $samples[] = $sample;
            }
            fclose($handle);
        }
    
        return $samples;
    }
    
    
    
}



// Explanation:

// The input data consists of one article and one reliable source.

// The article has the title "President Marcos is Dead" and some details. It belongs to the "Articles" category.
// The reliable source is named "Marcos Death" and has a source URL. It belongs to the "Reliable Sources" category.
// The predictions indicate whether each sample (article or reliable source) is relevant (1) or non-relevant (0) to the given filter ("marcos").

// In this case, the predictions are as follows:

// The article prediction is [1], indicating that the Naive Bayes classifier predicts it to be relevant to the filter.
// The reliable source predictions are [1, 1], indicating that both reliable sources are predicted to be relevant to the filter.