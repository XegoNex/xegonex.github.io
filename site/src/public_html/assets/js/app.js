class ServiceTabs {
  constructor(root) {
    this.root = root;
    if (!this.root) return;
    this.buttons = [...this.root.querySelectorAll('.services-tabs__btn')];
    this.panels = [...this.root.querySelectorAll('.services-tabs__panel')];
    this.activeId = this.buttons.find((btn) => btn.classList.contains('is-active'))?.dataset.tab ?? null;
    this.revealed = false;
    this.bind();
    this.observeReveal();
  }

  bind() {
    this.buttons.forEach((button) => {
      button.addEventListener('click', () => this.activate(button.dataset.tab));
    });
  }

  observeReveal() {
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (!entry.isIntersecting || this.revealed) return;
          this.revealed = true;
          this.showCards(this.panels.find((panel) => panel.classList.contains('is-active')));
          observer.disconnect();
        });
      },
      { threshold: 0.15 }
    );
    observer.observe(this.root);
  }

  activate(id) {
    if (!id || id === this.activeId) return;

    const nextButton = this.buttons.find((button) => button.dataset.tab === id);
    const nextPanel = this.panels.find((panel) => panel.dataset.panel === id);
    const currentPanel = this.panels.find((panel) => panel.classList.contains('is-active'));
    if (!nextButton || !nextPanel || !currentPanel) return;

    this.buttons.forEach((button) => {
      const selected = button.dataset.tab === id;
      button.classList.toggle('is-active', selected);
      button.setAttribute('aria-selected', String(selected));
    });

    currentPanel.classList.remove('is-active');
    currentPanel.classList.add('is-leaving');

    window.setTimeout(() => {
      currentPanel.hidden = true;
      currentPanel.classList.remove('is-leaving');
    }, 260);

    nextPanel.hidden = false;
    requestAnimationFrame(() => {
      nextPanel.classList.add('is-active');
      this.showCards(nextPanel);
    });

    this.activeId = id;
  }

  showCards(panel) {
    if (!panel) return;
    panel.querySelectorAll('.service-card').forEach((card, index) => {
      card.classList.remove('is-shown');
      window.setTimeout(() => card.classList.add('is-shown'), index * 55);
    });
  }
}

class FlowStrip {
  constructor(root) {
    this.root = root;
    if (!this.root) return;
    this.init();
  }

  init() {
    const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (prefersReduced) {
      this.root.classList.add('is-live');
      return;
    }

    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (!entry.isIntersecting) return;
          this.root.classList.add('is-live');
          observer.disconnect();
        });
      },
      { threshold: 0.4 }
    );

    observer.observe(this.root);
  }
}

class ScrollReveal {
  constructor(selector = '.reveal') {
    this.elements = [...document.querySelectorAll(selector)];
    this.observer = null;
    this.init();
  }

  init() {
    if (!this.elements.length) return;

    const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (prefersReduced) {
      this.elements.forEach((el) => el.classList.add('is-visible'));
      return;
    }

    this.observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (!entry.isIntersecting) return;
          entry.target.classList.add('is-visible');
          this.observer.unobserve(entry.target);
        });
      },
      { threshold: 0.15, rootMargin: '0px 0px -40px 0px' }
    );

    this.elements.forEach((el) => this.observer.observe(el));
  }
}

class Navigation {
  constructor() {
    this.header = document.querySelector('.header');
    this.burger = document.querySelector('[data-burger]');
    this.mobileNav = document.querySelector('[data-mobile-nav]');
    this.navLinks = [...document.querySelectorAll('.nav__link')];
    this.sections = [...document.querySelectorAll('section[id]')];
    this.bind();
  }

  bind() {
    window.addEventListener('scroll', () => this.onScroll(), { passive: true });
    this.onScroll();

    if (this.burger && this.mobileNav) {
      this.burger.addEventListener('click', () => this.toggleMenu());
      this.mobileNav.querySelectorAll('a').forEach((link) => {
        link.addEventListener('click', () => this.closeMenu());
      });
    }

    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
      anchor.addEventListener('click', (event) => {
        const id = anchor.getAttribute('href');
        if (!id || id === '#') return;
        const target = document.querySelector(id);
        if (!target) return;
        event.preventDefault();
        target.scrollIntoView({ behavior: 'smooth' });
        this.closeMenu();
      });
    });
  }

  onScroll() {
    const scrolled = window.scrollY > 24;
    this.header?.classList.toggle('is-scrolled', scrolled);
    this.updateActiveLink();
  }

  updateActiveLink() {
    const offset = 120;
    let current = '';

    this.sections.forEach((section) => {
      if (window.scrollY >= section.offsetTop - offset) {
        current = section.id;
      }
    });

    this.navLinks.forEach((link) => {
      link.classList.toggle('is-active', link.dataset.nav === current);
    });
  }

  toggleMenu() {
    const isOpen = this.burger.classList.toggle('is-open');
    this.mobileNav.classList.toggle('is-open', isOpen);
    this.mobileNav.hidden = !isOpen;
    this.burger.setAttribute('aria-expanded', String(isOpen));
    document.body.style.overflow = isOpen ? 'hidden' : '';
  }

  closeMenu() {
    if (!this.burger?.classList.contains('is-open')) return;
    this.burger.classList.remove('is-open');
    this.mobileNav?.classList.remove('is-open');
    if (this.mobileNav) this.mobileNav.hidden = true;
    this.burger.setAttribute('aria-expanded', 'false');
    document.body.style.overflow = '';
  }
}

class CursorGlow {
  constructor() {
    this.glow = document.querySelector('.cursor-glow');
    this.enabled = window.matchMedia('(pointer: fine)').matches;
    this.bind();
  }

  bind() {
    if (!this.glow || !this.enabled) return;

    let frame = null;
    let x = 0;
    let y = 0;

    document.addEventListener('mousemove', (event) => {
      x = event.clientX;
      y = event.clientY;
      if (frame) return;
      frame = requestAnimationFrame(() => {
        this.glow.style.left = `${x}px`;
        this.glow.style.top = `${y}px`;
        frame = null;
      });
    });
  }
}

class ProjectGalleryLightbox {
  constructor() {
    this.root = document.querySelector('[data-project-gallery-root]');
    if (!this.root) return;

    this.backdrop = this.root.querySelector('[data-gallery-backdrop]');
    this.titleEl = this.root.querySelector('[data-gallery-title]');
    this.track = this.root.querySelector('[data-gallery-track]');
    this.closeBtn = this.root.querySelector('[data-gallery-close]');
    this.cards = [...document.querySelectorAll('[data-project-gallery]')];
    this.isOpen = false;
    this.onKeyDown = this.onKeyDown.bind(this);

    this.bind();
  }

  bind() {
    this.cards.forEach((card) => {
      card.addEventListener('click', () => this.openFromCard(card));
      card.addEventListener('keydown', (event) => {
        if (event.key !== 'Enter' && event.key !== ' ') return;
        event.preventDefault();
        this.openFromCard(card);
      });
    });

    this.closeBtn?.addEventListener('click', () => this.close());
    this.backdrop?.addEventListener('click', () => this.close());
  }

  openFromCard(card) {
    const raw = card.dataset.projectGallery;
    const title = card.dataset.projectTitle ?? '';
    if (!raw) return;

    let images = [];
    try {
      images = JSON.parse(raw);
    } catch {
      return;
    }

    if (!Array.isArray(images) || !images.length) return;
    this.renderShots(images);
    this.titleEl.textContent = title;
    this.open();
  }

  renderShots(images) {
    this.track.replaceChildren();

    images.forEach((src, index) => {
      const figure = document.createElement('figure');
      figure.className = 'project-gallery__shot';
      figure.style.setProperty('--shot-delay', `${index * 70}ms`);

      const img = document.createElement('img');
      img.src = src;
      img.alt = '';
      img.loading = index === 0 ? 'eager' : 'lazy';

      figure.appendChild(img);
      this.track.appendChild(figure);
    });
  }

  open() {
    if (this.isOpen) return;
    this.isOpen = true;
    this.root.hidden = false;
    this.root.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
    document.addEventListener('keydown', this.onKeyDown);
    requestAnimationFrame(() => this.root.classList.add('is-open'));
  }

  close() {
    if (!this.isOpen) return;
    this.isOpen = false;
    this.root.classList.remove('is-open');
    this.root.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
    document.removeEventListener('keydown', this.onKeyDown);

    window.setTimeout(() => {
      if (this.isOpen) return;
      this.root.hidden = true;
      this.track.replaceChildren();
    }, 480);
  }

  onKeyDown(event) {
    if (event.key === 'Escape') this.close();
  }
}

class WorksCounter {
  constructor(root) {
    this.root = root;
    if (!this.root) return;

    this.valueEl = this.root.querySelector('[data-works-value]');
    this.target = Number.parseInt(this.root.dataset.worksCounter, 10);
    if (!this.valueEl || !Number.isFinite(this.target) || this.target < 1) return;

    this.started = false;
    this.observe();
  }

  observe() {
    const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (prefersReduced) {
      this.valueEl.textContent = String(this.target);
      return;
    }

    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (!entry.isIntersecting || this.started) return;
          this.started = true;
          this.animate();
          observer.disconnect();
        });
      },
      { threshold: 0.6 }
    );

    observer.observe(this.root);
  }

  animate() {
    const duration = 1800;
    const start = performance.now();

    const tick = (now) => {
      const progress = Math.min((now - start) / duration, 1);
      const eased = 1 - (1 - progress) ** 3;
      this.valueEl.textContent = String(Math.round(this.target * eased));
      if (progress < 1) requestAnimationFrame(tick);
    };

    requestAnimationFrame(tick);
  }
}

class App {
  constructor() {
    this.init();
  }

  init() {
    document.body.classList.add('is-ready');
    new ScrollReveal();
    new Navigation();
    new CursorGlow();
    document.querySelectorAll('[data-services-tabs]').forEach((root) => new ServiceTabs(root));
    document.querySelectorAll('[data-flow]').forEach((root) => new FlowStrip(root));
    document.querySelectorAll('[data-works-counter]').forEach((root) => new WorksCounter(root));
    new ProjectGalleryLightbox();
  }
}

document.addEventListener('DOMContentLoaded', () => new App());
