<?php
// ── Single source of truth for every admin-editable site image ──
function nexus_image_slots(): array {
    return [
        // Global
        ['logo', 'Site Logo (Dark Mode)', '/assets/images/logo.png', 'Global'],
        ['logo_light', 'Site Logo (Light Mode)', '/assets/images/logo-light.png', 'Global'],
        ['favicon', 'Favicon / Browser Icon', '/assets/images/favicon.ico', 'Global'],

        // Homepage
        ['home_cta', 'CTA Background', '/assets/images/cta-work.jpg', 'Homepage'],
        ['home_portfolio_1', 'Portfolio Card 1', '/assets/images/svc-seo.jpg', 'Homepage'],
        ['home_portfolio_2', 'Portfolio Card 2', '/assets/images/svc-web.jpg', 'Homepage'],
        ['home_portfolio_3', 'Portfolio Card 3', '/assets/images/svc-ads.jpg', 'Homepage'],
        ['home_testimonial_1', 'Testimonial Avatar 1', '/assets/images/client-bilal.jpg', 'Homepage'],
        ['home_testimonial_2', 'Testimonial Avatar 2', '/assets/images/client-aisha.jpg', 'Homepage'],
        ['home_testimonial_3', 'Testimonial Avatar 3', '/assets/images/client-hamza.jpg', 'Homepage'],

        // About
        ['about_teamwork', 'Teamwork Image', '/assets/images/about-teamwork.jpg', 'About'],
        ['about_team_1', 'Team Member 1', '/assets/images/team-usman.jpg', 'About'],
        ['about_team_2', 'Team Member 2', '/assets/images/team-irfan.jpg', 'About'],
        ['about_team_3', 'Team Member 3', '/assets/images/team-saad.jpg', 'About'],

        // Services (list page)
        ['svc_seo', 'SEO Service Image', '/assets/images/svc-seo.jpg', 'Services'],
        ['svc_ads', 'Digital Ads Service Image', '/assets/images/svc-ads.jpg', 'Services'],
        ['svc_ecom', 'E-Commerce Service Image', '/assets/images/svc-ecom.jpg', 'Services'],
        ['svc_web', 'Web Design Service Image', '/assets/images/svc-web.jpg', 'Services'],
        ['svc_perf', 'Performance Marketing Image', '/assets/images/svc-perf.jpg', 'Services'],
        ['svc_ai', 'AI Automation Service Image', '/assets/images/svc-ai.jpg', 'Services'],
        ['svc_brand', 'Brand Strategy Service Image', '/assets/images/svc-brand.jpg', 'Services'],

        // Service detail pages
        ['svc_seo_detail', 'SEO Detail Hero Image', '/assets/images/svc-seo.jpg', 'Services'],
        ['svc_ads_detail', 'Ads Detail Hero Image', '/assets/images/svc-ads.jpg', 'Services'],
        ['svc_ecom_detail', 'E-Commerce Detail Hero Image', '/assets/images/svc-ecom.jpg', 'Services'],
        ['svc_web_detail', 'Web Design Detail Hero Image', '/assets/images/svc-web.jpg', 'Services'],
        ['svc_perf_detail', 'Performance Marketing Detail Hero Image', '/assets/images/svc-perf.jpg', 'Services'],
        ['svc_ai_detail', 'AI Automation Detail Hero Image', '/assets/images/svc-ai.jpg', 'Services'],
        ['svc_brand_detail', 'Brand Detail Hero Image', '/assets/images/svc-brand.jpg', 'Services'],
        ['svc_marketing_detail', 'Digital Marketing Detail Hero Image', '/assets/images/svc-social.jpg', 'Services'],

        // Portfolio
        ['port_showcase_1', 'Showcase Project 1', '/assets/images/svc-seo.jpg', 'Portfolio'],
        ['port_showcase_2', 'Showcase Project 2', '/assets/images/svc-ads.jpg', 'Portfolio'],
        ['port_showcase_3', 'Showcase Project 3', '/assets/images/svc-web.jpg', 'Portfolio'],
        ['port_showcase_4', 'Showcase Project 4', '/assets/images/svc-social.jpg', 'Portfolio'],
        ['port_showcase_5', 'Showcase Project 5', '/assets/images/svc-brand.jpg', 'Portfolio'],
        ['port_showcase_6', 'Showcase Project 6', '/assets/images/svc-ai.jpg', 'Portfolio'],
        ['port_grid_1', 'Portfolio Grid 1', '/assets/images/svc-design.jpg', 'Portfolio'],
        ['port_grid_2', 'Portfolio Grid 2', '/assets/images/svc-dashboard.jpg', 'Portfolio'],
        ['port_grid_3', 'Portfolio Grid 3', '/assets/images/svc-brand.jpg', 'Portfolio'],
        ['port_grid_4', 'Portfolio Grid 4', '/assets/images/svc-perf.jpg', 'Portfolio'],
        ['port_grid_5', 'Portfolio Grid 5', '/assets/images/svc-ai.jpg', 'Portfolio'],
        ['port_grid_6', 'Portfolio Grid 6', '/assets/images/svc-social.jpg', 'Portfolio'],

        // Contact
        ['contact_office', 'Office Image', '/assets/images/contact-office.jpg', 'Contact'],
    ];
}