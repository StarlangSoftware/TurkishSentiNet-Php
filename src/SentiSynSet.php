<?php

namespace olcaytaner\Sentinet;

class SentiSynSet
{
    private string $id;
    private float $positiveScore;
    private float $negativeScore;

    /**
     * Constructor of SentiNet.SentiSynSet. Gets input id, positiveScore, negativeScore and sets all corresponding attributes.
     * @param string $id Id of the SentiNet.SentiSynSet.
     * @param float $positiveScore Positive score of the SentiNet.SentiSynSet.
     * @param float $negativeScore Negative score of the SentiNet.SentiSynSet.
     */
    public function __construct(string $id, float $positiveScore, float $negativeScore)
    {
        $this->id = $id;
        $this->positiveScore = $positiveScore;
        $this->negativeScore = $negativeScore;
    }

    /**
     * Accessor for the id attribute.
     * @return string Id of the SentiNet.SentiSynSet.
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Accessor for the positiveScore attribute.
     * @return float PositiveScore of the SentiNet.SentiSynSet.
     */
    public function getPositiveScore(): float
    {
        return $this->positiveScore;
    }

    /**
     * Accessor for the negativeScore attribute.
     * @return float NegativeScore of the SentiNet.SentiSynSet.
     */
    public function getNegativeScore(): float
    {
        return $this->negativeScore;
    }

    /**
     * Returns the polarityType of the sentiSynSet. If the positive score is larger than the negative score, the polarity is
     * positive; if the negative score is larger than the positive score, the polarity is negative; if both positive
     * score and negative score are equal, the polarity is neutral.
     * @return PolarityType SentiNet.PolarityType of the sentiSynSet.
     */
    public function getPolarity(): PolarityType
    {
        if ($this->positiveScore > $this->negativeScore) {
            return PolarityType::POSITIVE;
        } else {
            if ($this->positiveScore < $this->negativeScore) {
                return PolarityType::NEGATIVE;
            } else {
                return PolarityType::NEUTRAL;
            }
        }
    }
}