<?php
namespace Nguonchhay\NeosDisqus\Command;

/*
 * This file is part of the Nguonchhay.NeosDisqus package.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Cli\CommandController;

/**
 * @Flow\Scope("singleton")
 */
class ActivateCommandController extends CommandController
{

    const FUSION_CONTENT_CONDITION = 'disqusEmbeddedScript = ${q(site).property(\'disqusEmbeddedScript\')}';

    /**
     * @param string $siteKey
     * @param boolean $override
     *
     * @return void
     */
    public function disqusCommand($siteKey, $override = false)
    {
        $sitePath = FLOW_PATH_PACKAGES . 'Sites/' . $siteKey;
        if (!file_exists($sitePath . '/composer.json')) {
            $this->outputLine('Sites "' . $siteKey . '" does not exist.');
        } else {
            $this->copyCommonTemplate($siteKey, $override);
            $this->copyCommonFusion($siteKey);
            $this->outputLine('Disqus is activated.');
        }
    }

    /**
     * @param string $siteKey
     * @param boolean $override
     */
    protected function copyCommonTemplate($siteKey, $override)
    {
        $sitePath = FLOW_PATH_PACKAGES . 'Sites/' . $siteKey;
        $destination = $sitePath . '/Resources/Private/Templates/Page/Partials/Comment.html';
        $commentTemplate = FLOW_PATH_PACKAGES . 'Plugins/Nguonchhay.NeosDisqus/Resources/Private/StaticTemplates/Comment.html';
        if (!file_exists($destination) || $override) {
            copy($commentTemplate, $destination);
            $this->outputLine("\n- Copy template to: `$destination`");
        } else {
            $this->outputLine("\n- Comment template already exist at `$destination`");
        }
    }

    /**
     * @param string $siteKey
     */
    protected function copyCommonFusion($siteKey)
    {
        $sitePath = FLOW_PATH_PACKAGES . 'Sites/' . $siteKey;
        $siteFusionPath = $sitePath . '/Resources/Private/Fusion/Root.fusion';
        if (file_exists($siteFusionPath)) {
            $siteFusionContent = file_get_contents($siteFusionPath);
            if (!(strpos($siteFusionContent, self::FUSION_CONTENT_CONDITION) !== false)) {
                $fusionPath = FLOW_PATH_PACKAGES . 'Plugins/Nguonchhay.NeosDisqus/Resources/Private/StaticTemplates/Comment.fusion';
                $fusionContent = file_get_contents($fusionPath);
                $siteFusionContent .= "\n" . $fusionContent;
                if (file_put_contents($siteFusionPath, $siteFusionContent)) {
                    $this->outputLine("Copy fusion to: `$siteFusionPath``");
                }
            }
        }
    }
}
