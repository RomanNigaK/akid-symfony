<?php

namespace App\Application\Model\Response\Template;

use App\Entity\Template;

class GetTemplateResponseModel
{
    public string $id;
    public string $name;
    public string $abbreviation;
    public string $tag;
    public string $note;
    public string $type;

    public function __construct()
    {
    }

    public static function create(Template $template): self
    {

        $response = new self($template);
        $response->id = $template->getId();
        $response->name = $template->getName();
        $response->abbreviation = $template->getAbbreviation();
        $response->tag = $template->getTag();
        $response->note = $template->getNote();
        $response->type = $template->getType();


        return $response;
    }
}
