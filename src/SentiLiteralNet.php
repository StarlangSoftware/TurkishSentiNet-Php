<?php

namespace olcaytaner\Sentinet;

use olcaytaner\XmlParser\XmlDocument;

class SentiLiteralNet
{
    private array $sentiLiteralList;

    /**
     * Reads the Xml file that contains names of sentiLiterals and their positive, negative scores.
     * @param string $fileName Xml document that contains the SentiLiteralNet.
     */
    private function loadSentiNet(string $fileName): void
    {
        $name = "";
        $positiveScore = 0.0;
        $negativeScore = 0.0;
        $doc = new XmlDocument($fileName);
        $doc->parse();
        $rootNode = $doc->getFirstChild();
        $this->sentiLiteralList = [];
        $sentiSynSetNode = $rootNode->getFirstChild();
        while ($sentiSynSetNode != null) {
            $partNode = $sentiSynSetNode->getFirstChild();
            while ($partNode != null) {
                switch ($partNode->getName()) {
                    case "NAME":
                        $name = $partNode->getPcData();
                        break;
                    case "PSCORE":
                        $positiveScore = floatval($partNode->getPcData());
                        break;
                    case "NSCORE":
                        $negativeScore = floatval($partNode->getPcData());
                        break;
                }
                $partNode = $partNode->getNextSibling();
            }
            if ($name != "") {
                $this->sentiLiteralList[$name] = new SentiLiteral($name, $positiveScore, $negativeScore);
            }
            $sentiSynSetNode = $sentiSynSetNode->getNextSibling();
            $name = "";
            $positiveScore = 0.0;
            $negativeScore = 0.0;
        }
    }

    /**
     * Constructor of Turkish SentiNet.SentiNet. Reads the turkish_sentiliteralnet.xml file from the resources directory. For each
     * sentiLiteral read, it adds it to the sentiLiteralList.
     */
    public function __construct(string $fileName = "../turkish_sentiliteralnet.xml"){
        $this->loadSentiNet($fileName);
    }

    /**
     * Accessor for a single SentiLiteral.
     * @param string $name Name of the searched SentiLiteral.
     * @return SentiLiteral SentiLiteral with the given id.
     */
    public function getSentiLiteral(string $name): SentiLiteral{
        return $this->sentiLiteralList[$name];
    }

    /**
     * Constructs and returns an {@link Array} of lemma, which are the lemma of the {@link SentiLiteral}s having polarity
     * polarityType.
     * @param PolarityType $polarityType PolarityTypes of the searched {@link SentiLiteral}s
     * @return array An {@link Array} of lemma having polarityType polarityType.
     */
    private function getPolarity(PolarityType $polarityType): array{
        $result = [];
        foreach ($this->sentiLiteralList as $name => $sentiLiteral) {
            if ($sentiLiteral instanceOf SentiLiteral && $sentiLiteral->getPolarity() == $polarityType){
                $result[] = $sentiLiteral->getName();
            }
        }
        return $result;
    }

    /**
     * Returns the lemmas of all positive {@link SentiLiteral}s.
     * @return array An Array of lemmas of all positive {@link SentiLiteral}s.
     */
    public function getPositives(): array{
        return $this->getPolarity(PolarityType::POSITIVE);
    }

    /**
     * Returns the lemmas of all negative {@link SentiLiteral}s.
     * @return array An Array of lemmas of all negative {@link SentiLiteral}s.
     */
    public function getNegatives(): array{
        return $this->getPolarity(PolarityType::NEGATIVE);
    }

    /**
     * Returns the lemmas of all neutral {@link SentiLiteral}s.
     * @return array An Array of lemmas of all neutral {@link SentiLiteral}s.
     */
    public function getNeutrals(): array
    {
        return $this->getPolarity(PolarityType::NEUTRAL);
    }
}