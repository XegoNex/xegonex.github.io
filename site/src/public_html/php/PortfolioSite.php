<?php

declare(strict_types=1);

final class PortfolioSite
{
    private HtmlBuilder $html;

    public function __construct()
    {
        $this->html = new HtmlBuilder();
    }

    public function render(): string
    {
        $this->html->raw('<!DOCTYPE html>');
        $this->html->tag('html', ['lang' => 'ru'], $this->buildDocument());
        return $this->html->render();
    }

    private function buildDocument(): string
    {
        $inner = new HtmlBuilder();
        $inner->raw($this->buildHead());
        $inner->tag('body', [], $this->buildBody());
        return $inner->render();
    }

    private function buildHead(): string
    {
        $head = new HtmlBuilder();
        $head->tag('meta', ['charset' => 'UTF-8']);
        $head->tag('meta', ['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1.0']);
        $head->tag('meta', ['name' => 'description', 'content' => Config::DESCRIPTION]);
        $head->tag('meta', ['name' => 'theme-color', 'content' => '#0b0f14']);
        $head->tag('meta', ['property' => 'og:title', 'content' => Config::SITE_NAME]);
        $head->tag('meta', ['property' => 'og:description', 'content' => Config::DESCRIPTION]);
        $head->tag('meta', ['property' => 'og:image', 'content' => Config::absoluteUrl(Config::LOGO)]);
        $head->tag('meta', ['property' => 'og:type', 'content' => 'website']);
        if (Config::SITE_URL !== '') {
            $head->tag('meta', ['property' => 'og:url', 'content' => Config::SITE_URL]);
        }
        $head->tag('title', [], Config::PAGE_TITLE);
        $head->tag('link', ['rel' => 'preconnect', 'href' => 'https://fonts.googleapis.com']);
        $head->tag('link', ['rel' => 'preconnect', 'href' => 'https://fonts.gstatic.com', 'crossorigin' => true]);
        $head->tag('link', [
            'rel' => 'stylesheet',
            'href' => 'https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&family=Syne:wght@500;600;700;800&display=swap',
        ]);
        $head->tag('link', ['rel' => 'stylesheet', 'href' => 'assets/css/main.css']);
        $head->tag('link', ['rel' => 'icon', 'type' => 'image/png', 'href' => Config::LOGO]);
        return $head->render();
    }

    private function buildBody(): string
    {
        $body = new HtmlBuilder();
        $body->raw($this->buildAmbient());
        $body->raw($this->buildHeader());
        $body->tag('main', [], implode('', [
            $this->buildHero(),
            $this->buildSignal(),
            $this->buildServices(),
            $this->buildProjects(),
            $this->buildProjectsMore(),
            $this->buildStack(),
            $this->buildProcess(),
            $this->buildContact(),
        ]));
        $body->raw($this->buildFooter());
        $body->raw(ProjectGallery::modalMarkup());
        $body->tag('script', ['src' => 'assets/js/app.js', 'defer' => true]);
        return $body->render();
    }

    private function buildAmbient(): string
    {
        $ambient = new HtmlBuilder();
        $ambient->tag('div', ['class' => 'ambient', 'aria-hidden' => 'true'], implode('', [
            (new HtmlBuilder())->tag('div', ['class' => 'ambient__orb ambient__orb--one'])->render(),
            (new HtmlBuilder())->tag('div', ['class' => 'ambient__orb ambient__orb--two'])->render(),
            (new HtmlBuilder())->tag('div', ['class' => 'ambient__grid'])->render(),
            (new HtmlBuilder())->tag('div', ['class' => 'ambient__noise'])->render(),
        ]));
        $ambient->tag('div', ['class' => 'cursor-glow', 'aria-hidden' => 'true']);
        return $ambient->render();
    }

    private function buildHeader(): string
    {
        $ui = Config::ui();
        $header = new HtmlBuilder();
        $navLinks = '';
        foreach (Config::navigation() as $item) {
            $navLinks .= (new HtmlBuilder())->tag('a', [
                'href' => '#' . $item['id'],
                'class' => 'nav__link',
                'data-nav' => $item['id'],
            ], $item['label'])->render();
        }

        $header->tag('header', ['class' => 'header'], (new HtmlBuilder())->tag('div', ['class' => 'header__inner container'], implode('', [
            (new HtmlBuilder())->tag('a', ['href' => '#home', 'class' => 'brand'], implode('', [
                (new HtmlBuilder())->tag('img', [
                    'src' => Config::LOGO,
                    'alt' => Config::SITE_NAME,
                    'class' => 'brand__logo',
                    'width' => '48',
                    'height' => '48',
                ], null, true)->render(),
                (new HtmlBuilder())->tag('span', ['class' => 'brand__text'], Config::SITE_NAME)->render(),
            ]))->render(),
            (new HtmlBuilder())->tag('nav', ['class' => 'nav', 'aria-label' => $ui['nav_aria']], $navLinks)->render(),
            (new HtmlBuilder())->tag('a', ['href' => '#contact', 'class' => 'btn btn--primary btn--sm header__cta'], $ui['cta_header'])->render(),
            (new HtmlBuilder())->tag('button', [
                'class' => 'burger',
                'type' => 'button',
                'aria-label' => $ui['menu_open'],
                'aria-expanded' => 'false',
                'data-burger' => 'true',
            ], implode('', [
                (new HtmlBuilder())->tag('span')->render(),
                (new HtmlBuilder())->tag('span')->render(),
                (new HtmlBuilder())->tag('span')->render(),
            ]))->render(),
        ]))->render());

        $mobileLinks = '';
        foreach (Config::navigation() as $item) {
            $mobileLinks .= (new HtmlBuilder())->tag('a', [
                'href' => '#' . $item['id'],
                'class' => 'mobile-nav__link',
            ], $item['label'])->render();
        }
        $header->tag('div', ['class' => 'mobile-nav', 'data-mobile-nav' => 'true', 'hidden' => true], implode('', [
            (new HtmlBuilder())->tag('nav', ['class' => 'mobile-nav__panel'], $mobileLinks)->render(),
        ]));

        return $header->render();
    }

    private function buildHero(): string
    {
        $ui = Config::ui();
        $hero = new HtmlBuilder();
        $hero->tag('section', ['id' => 'home', 'class' => 'hero section'], (new HtmlBuilder())->tag('div', ['class' => 'container hero__grid'], implode('', [
            (new HtmlBuilder())->tag('div', ['class' => 'hero__content reveal'], implode('', [
                (new HtmlBuilder())->tag('p', ['class' => 'eyebrow'], $ui['hero_eyebrow'])->render(),
                (new HtmlBuilder())->tag('h1', ['class' => 'hero__title'], implode('', [
                    $ui['hero_title_prefix'],
                    (new HtmlBuilder())->tag('span', ['class' => 'text-gradient'], $ui['hero_title_highlight'])->render(),
                ]))->render(),
                (new HtmlBuilder())->tag('p', ['class' => 'hero__lead'], Config::DESCRIPTION)->render(),
                (new HtmlBuilder())->tag('div', ['class' => 'hero__actions'], implode('', [
                    (new HtmlBuilder())->tag('a', ['href' => '#projects', 'class' => 'btn btn--primary'], $ui['hero_btn_work'])->render(),
                    (new HtmlBuilder())->tag('a', ['href' => '#contact', 'class' => 'btn btn--ghost'], $ui['hero_btn_contact'])->render(),
                ]))->render(),
            ]))->render(),
            (new HtmlBuilder())->tag('div', ['class' => 'hero__visual reveal reveal--delay'], implode('', [
                (new HtmlBuilder())->tag('div', ['class' => 'hero__logo-wrap'], implode('', [
                    (new HtmlBuilder())->tag('div', ['class' => 'hero__ring hero__ring--outer'])->render(),
                    (new HtmlBuilder())->tag('div', ['class' => 'hero__ring hero__ring--inner'])->render(),
                    (new HtmlBuilder())->tag('img', [
                        'src' => Config::LOGO,
                        'alt' => Config::SITE_NAME,
                        'class' => 'hero__logo',
                        'width' => '320',
                        'height' => '320',
                    ], null, true)->render(),
                ]))->render(),
                (new HtmlBuilder())->tag('div', ['class' => 'hero__badge'], implode('', [
                    (new HtmlBuilder())->tag('span', ['class' => 'hero__badge-dot'])->render(),
                    $ui['hero_badge'],
                ]))->render(),
            ]))->render(),
        ]))->render());
        return $hero->render();
    }

    private function buildSignal(): string
    {
        $dots = '';
        for ($i = 0; $i < 9; $i++) {
            $dots .= (new HtmlBuilder())->tag('span', ['class' => 'flow__tick'])->render();
        }

        $frame = (new HtmlBuilder())->tag('div', ['class' => 'flow reveal', 'data-flow' => 'true'], implode('', [
            (new HtmlBuilder())->tag('div', ['class' => 'flow__line'], implode('', [
                (new HtmlBuilder())->tag('span', ['class' => 'flow__glow'])->render(),
                (new HtmlBuilder())->tag('span', ['class' => 'flow__dot flow__dot--a'])->render(),
                (new HtmlBuilder())->tag('span', ['class' => 'flow__dot flow__dot--b'])->render(),
                (new HtmlBuilder())->tag('div', ['class' => 'flow__ticks'], $dots)->render(),
            ]))->render(),
            (new HtmlBuilder())->tag('div', ['class' => 'flow__core'], implode('', [
                (new HtmlBuilder())->tag('span', ['class' => 'flow__diamond'])->render(),
                (new HtmlBuilder())->tag('span', ['class' => 'flow__ring flow__ring--one'])->render(),
                (new HtmlBuilder())->tag('span', ['class' => 'flow__ring flow__ring--two'])->render(),
            ]))->render(),
        ]))->render();

        return (new HtmlBuilder())->tag('section', ['class' => 'section flow-section'], (new HtmlBuilder())->tag('div', ['class' => 'container'], $frame))->render();
    }

    private function buildServices(): string
    {
        $ui = Config::ui();
        $categories = Config::serviceCategories();

        $navButtons = '';
        $panels = '';
        foreach ($categories as $index => $category) {
            $isActive = $index === 0;
            $navButtons .= (new HtmlBuilder())->tag('button', [
                'type' => 'button',
                'class' => 'services-tabs__btn' . ($isActive ? ' is-active' : ''),
                'data-tab' => $category['id'],
                'aria-selected' => $isActive ? 'true' : 'false',
            ], $category['label'])->render();

            $cards = '';
            foreach ($category['items'] as $itemIndex => $item) {
                $cards .= (new HtmlBuilder())->tag('article', [
                    'class' => 'service-card',
                    'style' => '--card-delay:' . ($itemIndex * 60) . 'ms',
                ], implode('', [
                    (new HtmlBuilder())->tag('div', ['class' => 'service-card__icon', 'data-icon' => $item['icon']])->render(),
                    (new HtmlBuilder())->tag('h3', ['class' => 'service-card__title'], $item['title'])->render(),
                    (new HtmlBuilder())->tag('p', ['class' => 'service-card__text'], $item['text'])->render(),
                ]))->render();
            }

            $panels .= (new HtmlBuilder())->tag('div', [
                'class' => 'services-tabs__panel' . ($isActive ? ' is-active' : ''),
                'data-panel' => $category['id'],
                'hidden' => $isActive ? null : true,
            ], (new HtmlBuilder())->tag('div', ['class' => 'services__grid'], $cards)->render())->render();
        }

        $section = new HtmlBuilder();
        $section->tag('section', ['id' => 'services', 'class' => 'section services'], (new HtmlBuilder())->tag('div', ['class' => 'container'], implode('', [
            (new HtmlBuilder())->tag('div', ['class' => 'section-head reveal'], implode('', [
                (new HtmlBuilder())->tag('p', ['class' => 'eyebrow'], $ui['services_eyebrow'])->render(),
                (new HtmlBuilder())->tag('h2', ['class' => 'section-head__title'], $ui['services_title'])->render(),
                (new HtmlBuilder())->tag('p', ['class' => 'section-head__text'], $ui['services_text'])->render(),
            ]))->render(),
            (new HtmlBuilder())->tag('div', ['class' => 'services-tabs reveal', 'data-services-tabs' => 'true'], implode('', [
                (new HtmlBuilder())->tag('div', ['class' => 'services-tabs__nav', 'role' => 'tablist'], $navButtons)->render(),
                (new HtmlBuilder())->tag('div', ['class' => 'services-tabs__panels'], $panels)->render(),
            ]))->render(),
        ]))->render());
        return $section->render();
    }

    private function buildProjects(): string
    {
        $cards = '';
        foreach (Config::projects() as $index => $project) {
            $media = $project['image']
                ? (new HtmlBuilder())->tag('img', [
                    'src' => $project['image'],
                    'alt' => $project['title'],
                    'class' => 'project-card__img',
                    'loading' => 'lazy',
                ], null, true)->render()
                : (new HtmlBuilder())->tag('div', ['class' => 'project-card__placeholder'], implode('', [
                    (new HtmlBuilder())->tag('img', [
                        'src' => Config::LOGO,
                        'alt' => '',
                        'class' => 'project-card__placeholder-logo',
                        'aria-hidden' => 'true',
                    ], null, true)->render(),
                ]))->render();

            $tags = '';
            foreach ($project['tags'] as $tag) {
                $tags .= (new HtmlBuilder())->tag('span', ['class' => 'tag'], $tag)->render();
            }

            $cardAttrs = [
                'class' => 'project-card reveal' . (isset($project['gallery']) ? ' project-card--gallery' : ''),
                'style' => '--reveal-delay:' . ($index * 80) . 'ms',
            ];

            if (isset($project['gallery'])) {
                $cardAttrs['data-project-gallery'] = json_encode($project['gallery'], JSON_UNESCAPED_UNICODE);
                $cardAttrs['data-project-title'] = $project['title'];
                $cardAttrs['tabindex'] = '0';
                $cardAttrs['role'] = 'button';
            }

            $cards .= (new HtmlBuilder())->tag('article', $cardAttrs, implode('', [
                (new HtmlBuilder())->tag('div', ['class' => 'project-card__media'], $media)->render(),
                (new HtmlBuilder())->tag('div', ['class' => 'project-card__body'], implode('', [
                    (new HtmlBuilder())->tag('span', ['class' => 'project-card__category'], $project['category'])->render(),
                    (new HtmlBuilder())->tag('h3', ['class' => 'project-card__title'], $project['title'])->render(),
                    (new HtmlBuilder())->tag('p', ['class' => 'project-card__text'], $project['description'])->render(),
                    (new HtmlBuilder())->tag('div', ['class' => 'project-card__tags'], $tags)->render(),
                ]))->render(),
            ]))->render();
        }

        $ui = Config::ui();
        $section = new HtmlBuilder();
        $section->tag('section', ['id' => 'projects', 'class' => 'section projects'], (new HtmlBuilder())->tag('div', ['class' => 'container'], implode('', [
            (new HtmlBuilder())->tag('div', ['class' => 'section-head reveal'], implode('', [
                (new HtmlBuilder())->tag('p', ['class' => 'eyebrow'], $ui['projects_eyebrow'])->render(),
                (new HtmlBuilder())->tag('h2', ['class' => 'section-head__title'], $ui['projects_title'])->render(),
                (new HtmlBuilder())->tag('div', ['class' => 'section-head__meta'], implode('', [
                    (new HtmlBuilder())->tag('p', ['class' => 'section-head__text section-head__author'], $ui['projects_text'])->render(),
                    (new HtmlBuilder())->tag('div', [
                        'class' => 'works-counter',
                        'data-works-counter' => (string) Config::COMPLETED_WORKS,
                    ], implode('', [
                        (new HtmlBuilder())->tag('span', ['class' => 'works-counter__label'], $ui['works_label'])->render(),
                        (new HtmlBuilder())->tag('span', ['class' => 'works-counter__value', 'data-works-value' => 'true'], '0')->render(),
                    ]))->render(),
                ]))->render(),
            ]))->render(),
            (new HtmlBuilder())->tag('div', ['class' => 'projects__grid'], $cards)->render(),
        ]))->render());
        return $section->render();
    }

    private function buildProjectsMore(): string
    {
        $ui = Config::ui();
        return (new HtmlBuilder())->tag('div', ['class' => 'projects-more'], (new HtmlBuilder())->tag('div', ['class' => 'container'], (new HtmlBuilder())->tag('p', ['class' => 'projects-more__text reveal'], $ui['projects_more'])->render()))->render();
    }

    private function buildStack(): string
    {
        $items = '';
        foreach (Config::stack() as $tech) {
            $items .= (new HtmlBuilder())->tag('span', ['class' => 'stack__item reveal'], $tech)->render();
        }

        $ui = Config::ui();
        return (new HtmlBuilder())->tag('section', ['class' => 'section stack'], (new HtmlBuilder())->tag('div', ['class' => 'container stack__inner reveal'], implode('', [
            (new HtmlBuilder())->tag('p', ['class' => 'stack__label'], $ui['stack_label'])->render(),
            (new HtmlBuilder())->tag('div', ['class' => 'stack__track'], $items)->render(),
        ]))->render();
    }

    private function buildProcess(): string
    {
        $steps = '';
        foreach (Config::process() as $step) {
            $steps .= (new HtmlBuilder())->tag('article', ['class' => 'process-step reveal'], implode('', [
                (new HtmlBuilder())->tag('span', ['class' => 'process-step__num'], $step['step'])->render(),
                (new HtmlBuilder())->tag('h3', ['class' => 'process-step__title'], $step['title'])->render(),
                (new HtmlBuilder())->tag('p', ['class' => 'process-step__text'], $step['text'])->render(),
            ]))->render();
        }

        $ui = Config::ui();
        $section = new HtmlBuilder();
        $section->tag('section', ['id' => 'process', 'class' => 'section process'], (new HtmlBuilder())->tag('div', ['class' => 'container'], implode('', [
            (new HtmlBuilder())->tag('div', ['class' => 'section-head reveal'], implode('', [
                (new HtmlBuilder())->tag('p', ['class' => 'eyebrow'], $ui['process_eyebrow'])->render(),
                (new HtmlBuilder())->tag('h2', ['class' => 'section-head__title'], $ui['process_title'])->render(),
            ]))->render(),
            (new HtmlBuilder())->tag('div', ['class' => 'process__grid'], $steps)->render(),
        ]))->render());
        return $section->render();
    }

    private function buildContact(): string
    {
        $links = '';
        foreach (Config::contacts() as $contact) {
            $attrs = [
                'href' => $contact['href'],
                'class' => 'contact-card reveal',
                'data-contact' => $contact['type'],
            ];
            if (str_starts_with($contact['href'], 'http')) {
                $attrs['target'] = '_blank';
                $attrs['rel'] = 'noopener noreferrer';
            }
            $links .= (new HtmlBuilder())->tag('a', $attrs, implode('', [
                (new HtmlBuilder())->tag('span', ['class' => 'contact-card__label'], $contact['label'])->render(),
                (new HtmlBuilder())->tag('span', ['class' => 'contact-card__value'], $contact['value'])->render(),
            ]))->render();
        }

        $trustItems = '';
        foreach (Config::trustFeatures() as $feature) {
            $trustItems .= (new HtmlBuilder())->tag('li', ['class' => 'trust-pill reveal'], implode('', [
                (new HtmlBuilder())->tag('span', ['class' => 'trust-pill__icon', 'data-icon' => $feature['icon']])->render(),
                (new HtmlBuilder())->tag('span', ['class' => 'trust-pill__text'], $feature['text'])->render(),
            ]))->render();
        }

        $ui = Config::ui();
        $section = new HtmlBuilder();
        $section->tag('section', ['id' => 'contact', 'class' => 'section contact'], (new HtmlBuilder())->tag('div', ['class' => 'container contact__grid'], implode('', [
            (new HtmlBuilder())->tag('div', ['class' => 'contact__intro reveal'], implode('', [
                (new HtmlBuilder())->tag('p', ['class' => 'eyebrow'], $ui['contact_eyebrow'])->render(),
                (new HtmlBuilder())->tag('h2', ['class' => 'section-head__title'], $ui['contact_title'])->render(),
                (new HtmlBuilder())->tag('p', ['class' => 'section-head__text'], $ui['contact_text'])->render(),
                (new HtmlBuilder())->tag('ul', ['class' => 'trust-pills'], $trustItems)->render(),
                (new HtmlBuilder())->tag('div', ['class' => 'contact__logo'], (new HtmlBuilder())->tag('img', [
                    'src' => Config::LOGO,
                    'alt' => Config::SITE_NAME,
                    'width' => '120',
                    'height' => '120',
                ], null, true)->render())->render(),
            ]))->render(),
            (new HtmlBuilder())->tag('div', ['class' => 'contact__links'], $links)->render(),
        ]))->render());
        return $section->render();
    }

    private function buildFooter(): string
    {
        $ui = Config::ui();
        return (new HtmlBuilder())->tag('footer', ['class' => 'footer'], (new HtmlBuilder())->tag('div', ['class' => 'container footer__inner'], implode('', [
            (new HtmlBuilder())->tag('div', ['class' => 'footer__brand'], implode('', [
                (new HtmlBuilder())->tag('img', [
                    'src' => Config::LOGO,
                    'alt' => '',
                    'class' => 'footer__logo',
                    'width' => '32',
                    'height' => '32',
                    'aria-hidden' => 'true',
                ], null, true)->render(),
                (new HtmlBuilder())->tag('span', [], Config::SITE_NAME)->render(),
            ]))->render(),
            (new HtmlBuilder())->tag('p', ['class' => 'footer__copy'], '© ' . Config::YEAR . ' ' . Config::SITE_NAME . '. ' . $ui['footer_rights'])->render(),
            (new HtmlBuilder())->tag('a', ['href' => '#home', 'class' => 'footer__top'], $ui['footer_top'])->render(),
        ]))->render();
    }
}
