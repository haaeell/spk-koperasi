<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PerhitunganController extends Controller
{
    public function calculateSMART($koperasis, $kriterias, $nilaiAlternatif, $bobotKriteria)
{
    $finalScores = [];

    // Loop through each koperasi
    foreach ($koperasis as $koperasi) {
        $totalScore = 0;

        // Loop through each criterion
        foreach ($kriterias as $kriteria) {
            $kriteriaWeight = $bobotKriteria[$kriteria->id];

            // Normalize the values of sub-criteria for the current criterion
            $subKriteriaScores = [];
            foreach ($kriteria->subKriteria as $subKriteria) {
                $subKriteriaScores[] = $nilaiAlternatif[$koperasi->id . '-' . $subKriteria->id]->nilai;
            }

            $maxScore = max($subKriteriaScores);
            $minScore = min($subKriteriaScores);

            // Calculate the normalized values for each sub-criterion
            $normalizedScores = [];
            foreach ($subKriteriaScores as $score) {
                $normalizedScores[] = ($score - $minScore) / ($maxScore - $minScore);
            }

            // Multiply normalized score by the weight of the criterion
            $weightedSum = 0;
            foreach ($normalizedScores as $normalizedScore) {
                $weightedSum += $normalizedScore * $kriteriaWeight;
            }

            // Add to the total score for the koperasi
            $totalScore += $weightedSum;
        }

        // Store the final score for each koperasi
        $finalScores[$koperasi->id] = $totalScore;
    }

    // Sort koperasis by final score in descending order (best to worst)
    arsort($finalScores);

    return $finalScores;
}

}
