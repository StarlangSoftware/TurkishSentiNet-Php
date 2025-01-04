<?php

namespace olcaytaner\Sentinet;

class SentiLiteral
{
    private string $name;
    private float $positiveScore;
    private float $negativeScore;

    /**
     * Constructor of SentiLiteral. Gets input literal, positiveScore, negativeScore and sets all corresponding attributes.
     * @param string $name Name of the literal.
     * @param float $positiveScore Positive score of the literal.
     * @param float $negativeScore Negative score of the literal.
     */
    public function __construct(string $name, float $positiveScore, float $negativeScore){
        $this->name = $name;
        $this->positiveScore = $positiveScore;
        $this->negativeScore = $negativeScore;
    }

    /**
     * Accessor for the positiveScore attribute.
     * @return float PositiveScore of the SentiLiteral.
     */
    public function getPositiveScore(): float
    {
        return $this->positiveScore;
    }

    /**
     * Accessor for the negativeScore attribute.
     * @return float NegativeScore of the SentiLiteral.
     */
    public function getNegativeScore(): float
    {
        return $this->negativeScore;
    }

    /**
     * Accessor for the name attribute.
     * @return string Name of the SentiLiteral.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns the polarityType of the literal. If the positive score is larger than the negative score, the polarity is
     * positive; if the negative score is larger than the positive score, the polarity is negative; if both positive
     * score and negative score are equal, the polarity is neutral.
     * @return PolarityType SentiNet.PolarityType of the literal.
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