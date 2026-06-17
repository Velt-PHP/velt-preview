<?php

namespace PreviewEndpoints;

use VeltView\VeltPageRepository;

class VeltPageRepositoryFactory
{
    public static function create(string $templatesPath): VeltPageRepository
    {
        return new VeltPageRepository($templatesPath);
    }
}
