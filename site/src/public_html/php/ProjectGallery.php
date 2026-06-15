<?php

declare(strict_types=1);

final class ProjectGallery
{
    public static function modalMarkup(): string
    {
        $builder = new HtmlBuilder();

        $builder->tag('div', [
            'class' => 'project-gallery',
            'data-project-gallery-root' => 'true',
            'hidden' => true,
            'aria-hidden' => 'true',
        ], implode('', [
            (new HtmlBuilder())->tag('div', [
                'class' => 'project-gallery__backdrop',
                'data-gallery-backdrop' => 'true',
            ])->render(),
            (new HtmlBuilder())->tag('div', [
                'class' => 'project-gallery__dialog',
                'data-gallery-dialog' => 'true',
                'role' => 'dialog',
                'aria-modal' => 'true',
            ], implode('', [
                (new HtmlBuilder())->tag('div', ['class' => 'project-gallery__head'], implode('', [
                    (new HtmlBuilder())->tag('h3', [
                        'class' => 'project-gallery__title',
                        'data-gallery-title' => 'true',
                    ], '')->render(),
                    (new HtmlBuilder())->tag('button', [
                        'type' => 'button',
                        'class' => 'project-gallery__close',
                        'data-gallery-close' => 'true',
                        'aria-label' => 'Закрыть',
                    ], implode('', [
                        (new HtmlBuilder())->tag('span', ['aria-hidden' => 'true'])->render(),
                        (new HtmlBuilder())->tag('span', ['aria-hidden' => 'true'])->render(),
                    ]))->render(),
                ]))->render(),
                (new HtmlBuilder())->tag('div', ['class' => 'project-gallery__body'], implode('', [
                    (new HtmlBuilder())->tag('div', [
                        'class' => 'project-gallery__track',
                        'data-gallery-track' => 'true',
                    ])->render(),
                ]))->render(),
            ]))->render(),
        ]));

        return $builder->render();
    }
}
