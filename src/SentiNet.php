<?php

namespace olcaytaner\Sentinet;

use olcaytaner\XmlParser\XmlDocument;

class SentiNet
{
    private array $sentiSynSetList;

    /**
     * Reads the Xml file that contains names of sentiSynSets and their positive, negative scores.
     * @param string $fileName Xml document that contains the SentiNet.
     */
    private function loadSentiNet(string $fileName): void
    {
        $id = "";
        $positiveScore = 0.0;
        $negativeScore = 0.0;
        $doc = new XmlDocument($fileName);
        $doc->parse();
        $rootNode = $doc->getFirstChild();
        $this->sentiSynSetList = [];
        $sentiSynSetNode = $rootNode->getFirstChild();
        while ($sentiSynSetNode != null) {
            $partNode = $sentiSynSetNode->getFirstChild();
            while ($partNode != null) {
                switch ($partNode->getName()) {
                    case "ID":
                        $id = $partNode->getPcData();
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
            if ($id != "") {
                $this->sentiSynSetList[$id] = new SentiSynSet($id, $positiveScore, $negativeScore);
            }
            $sentiSynSetNode = $sentiSynSetNode->getNextSibling();
            $id = "";
            $positiveScore = 0.0;
            $negativeScore = 0.0;
        }
    }

    /**
     * Constructor of Turkish SentiNet.SentiNet. Reads the turkish_sentinet.xml file from the resources directory. For each
     * sentiSynSet read, it adds it to the sentiSynSetList.
     */
    public function __construct(string $fileName = "../turkish_sentinet.xml"){
       $this->loadSentiNet($fileName);
    }

    /**
     * Accessor for a single SentiNet.SentiSynSet.
     * @param string $id Id of the searched SentiNet.SentiSynSet.
     * @return SentiSynSet SentiNet.SentiSynSet with the given id.
     */
    public function getSentiSynSet(string $id): SentiSynSet{
        return $this->sentiSynSetList[$id];
    }

    /**
     * Adds specified SentiNet.SentiSynSet to the SentiNet.SentiSynSet list.
     *
     * @param SentiSynSet $sentiSynSet SentiNet.SentiSynSet to be added
     */
    public function addSentiSynSet(SentiSynSet $sentiSynSet): void{
        $this->sentiSynSetList[$sentiSynSet->getId()] = $sentiSynSet;
    }

    /**
     * Removes specified SentiNet.SentiSynSet from the SentiNet.SentiSynSet list.
     *
     * @param SentiSynSet $sentiSynSet SentiNet.SentiSynSet to be removed
     */
    public function removeSentiSynSet(SentiSynSet $sentiSynSet): void{
        $this->sentiSynSetList[$sentiSynSet->getId()] = null;
    }

    /**
     * Constructs and returns an {@link Array} of ids, which are the ids of the {@link SentiSynSet}s having polarity
     * polarityType.
     * @param PolarityType $polarityType PolarityTypes of the searched {@link SentiSynSet}s
     * @return array An {@link Array} of id having polarityType polarityType.
     */
    private function getPolarity(PolarityType $polarityType): array{
        $result = [];
        foreach ($this->sentiSynSetList as $id => $sentiSynSet) {
            if ($sentiSynSet instanceOf SentiSynSet && $sentiSynSet->getPolarity() == $polarityType){
                $result[] = $sentiSynSet->getId();
            }
        }
        return $result;
    }

    /**
     * Returns the ids of all positive {@link SentiSynSet}s.
     * @return array An Array of ids of all positive {@link SentiSynSet}s.
     */
    public function getPositives(): array{
        return $this->getPolarity(PolarityType::POSITIVE);
    }

    /**
     * Returns the ids of all negative {@link SentiSynSet}s.
     * @return array An Array of ids of all negative {@link SentiSynSet}s.
     */
    public function getNegatives(): array{
        return $this->getPolarity(PolarityType::NEGATIVE);
    }

    /**
     * Returns the ids of all neutral {@link SentiSynSet}s.
     * @return array An Array of ids of all neutral {@link SentiSynSet}s.
     */
    public function getNeutrals(): array
    {
        return $this->getPolarity(PolarityType::NEUTRAL);
    }
}