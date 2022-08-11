<?php
declare(strict_types=1);

namespace App\Application\Actions\Ocr;

use Psr\Http\Message\ResponseInterface as Response;
use Google\Cloud\Vision\V1\Feature\Type;

class TestAction extends OcrAction
{
    const IMAGES = [
        1 => 'MarlboroGold-0001.jpg',
        2 => 'MarlboroGold-0002.jpg',
        3 => 'MarlboroGold-0003.png',
    ];

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $id = (int)$this->args['id'];
        if (!isset(self::IMAGES[$id])) {
            return $this->respondWithData(['no images.']);
        }

        $pathSettings = $this->settings->get('path');
        $annotation = $this->client->annotateImage(
            fopen($pathSettings['data'] . '/example/' . self::IMAGES[$id], 'r'),
            [Type::TEXT_DETECTION],
            ['languageHints' => 'en'],
        );

        $descriptions = [];
        foreach ($annotation->getTextAnnotations() as $text) {
            $descriptions[] = $text->getDescription();
        }

        return $this->respondWithData($descriptions);
    }
}
