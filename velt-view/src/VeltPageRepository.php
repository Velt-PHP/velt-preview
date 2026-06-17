<?php

namespace VeltView;

use PreviewContracts\Contracts\PageRepositoryInterface;
use PreviewContracts\PreviewPage;

class VeltPageRepository implements PageRepositoryInterface
{
    public function __construct(
        private string $templatesPath
    ) {
        VeltView::setTemplatesPath($templatesPath);
    }

    public function findByView(string $view): ?PreviewPage
    {
        try {
            $veltView = VeltView::fromSession($view);
            $array = $veltView->toArray();

            return new PreviewPage(
                $view,
                $array['components'] ?? [],
                $array['meta'] ?? []
            );
        } catch (\RuntimeException $e) {
            return null;
        }
    }
}
