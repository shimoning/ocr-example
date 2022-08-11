<?php
declare(strict_types=1);

namespace App\Application\Actions\Ocr;

use App\Application\Actions\Action;
use Psr\Log\LoggerInterface;
use App\Application\Settings\SettingsInterface;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;

abstract class OcrAction extends Action
{
    protected ImageAnnotatorClient $client;

    public function __construct(
        LoggerInterface $logger,
        SettingsInterface $settings,
        ImageAnnotatorClient $client,
    ) {
        parent::__construct($logger, $settings);
        $this->client = $client;
    }
}
