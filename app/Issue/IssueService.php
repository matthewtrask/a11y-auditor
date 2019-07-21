<?php

declare(strict_types=1);

namespace App\Issue;

use App\Standards\ConformanceLevels;

class IssueService
{
    private const A = 'A';
    private const AA = 'AA';
    private const AAA = 'AAA';

    private static $conformanceLevels = [
        self::A,
        self::AA,
        self::AAA,
    ];

    public function buildDescription(Issue $issue) : void
    {
        $description = '';

        if ($issue->getDescription()) {
            $description .= $this->addDescription($issue->getDescription()) . PHP_EOL;
        }

        if ($issue->getCurrentCode()) {
            $description .= $this->addCurrentCode($issue->getCurrentCode()) . PHP_EOL;
        }

        if ($issue->getSolution()) {
            $description .= $this->addSolution($issue->getSolution()) . PHP_EOL;
        }

        if ($issue->getSuggestedCode()) {
            $description .= $this->addSuggestedCode($issue->getSuggestedCode()) . PHP_EOL;
        }

        if ($issue->getAffectedCommunities()) {
            $description .= $this->addAffectedCommunities($issue->getAffectedCommunities()) . PHP_EOL;
        }

        if ($issue->getEnvironment()) {
            $description .= $this->addEnvironment($issue->getEnvironment()) . PHP_EOL;
        }

        $issue->setCombinedDescription($description);
    }

    public function addLevelTags(Issue $issue)
    {
        foreach($issue->getTags() as $tag) {
            if (!$this->hasConformanceLevel($tag)) {
                $this->addConformanceTag($tag, $issue);
            }
        }
    }

    private function hasConformanceLevel(string $tag) : bool
    {
        return in_array($tag, self::$conformanceLevels);
    }

    private function addConformanceTag(string $tag, Issue $issue) : void
    {
        if (in_array($tag, ConformanceLevels::$levelA))  {
            $this->addALevelConformanceTag($issue);
        }

        if (in_array($tag, ConformanceLevels::$levelAA)) {
            $this->addAALevelConformanceTag($issue);
        }

        if (in_array($tag, ConformanceLevels::$levelAAA)) {
            $this->addAAALevelConformanceTag($issue);
        }
    }

    private function addALevelConformanceTag(Issue $issue) : void
    {
        $issue->addTag(self::A);
    }

    private function addAALevelConformanceTag(Issue $issue) : void
    {
        $issue->addTag(self::AA);
    }

    private function addAAALevelConformanceTag(Issue $issue) : void
    {
        $issue->addTag(self::AAA);
    }

    private function addDescription(string $description) : string
    {
        return $this->buildDescriptionString($description, Issue::CURRENT_CODE);
    }

    private function addCurrentCode(string $currentCode) : string
    {
        return$this->buildDescriptionString($currentCode, Issue::CURRENT_CODE);
    }

    private function addSolution(string $solution) : string
    {
        return $this->buildDescriptionString($solution, Issue::SOLUTION);
    }

    private function addSuggestedCode(string $suggestedCode) : string
    {
        return $this->buildDescriptionString($suggestedCode, Issue::SUGGESTED_CODE);
    }

    private function addAffectedCommunities(string $affectedCommunities) : string
    {
        return $this->buildDescriptionString($affectedCommunities, Issue::AFFECTED_COMMUNITIES);
    }

    private function addEnvironment(string $environment) : string
    {
        return $this->buildDescriptionString($environment, Issue::ENVIRONMENT);
    }

    private function buildDescriptionString(string $text, string $header) : string
    {
        return sprintf(
'%s 
%s',
            $header, $text);
    }
}