$(function () {
    const sidebar = $('#appSidebar');
    const backdrop = $('#navBackdrop');
    function closeNavigation() {
        sidebar.removeClass('mobile-open');
        backdrop.prop('hidden', true);
        $('#mobileMenuBtn').attr('aria-expanded', 'false');
    }
    $('#mobileMenuBtn').on('click', function () {
        const open = !sidebar.hasClass('mobile-open');
        sidebar.toggleClass('mobile-open', open);
        backdrop.prop('hidden', !open);
        $(this).attr('aria-expanded', String(open));
    });
    backdrop.on('click', closeNavigation);
    $(window).on('resize', function () { if (window.innerWidth >= 768) closeNavigation(); });
    const current = location.pathname.split('/').pop().replace(/\.php$/, '') || 'dashboard';
    sidebar.find('a').each(function () {
        if (this.getAttribute('href').replace(/\.php$/, '') === current) {
            $(this).attr('aria-current', 'page').addClass('nav-active');
            const submenu = $(this).closest('.nav-submenu');
            submenu.show().prev('button').attr('aria-expanded', 'true').find('.nav-arrow').addClass('rotate-180');
        }
    });
    $('.nav-group').on('click', function () {
        const menu = $('#' + $(this).attr('aria-controls'));
        const open = $(this).attr('aria-expanded') !== 'true';
        menu.stop(true, true)[open ? 'slideDown' : 'slideUp'](160);
        $(this).attr('aria-expanded', String(open)).find('.nav-arrow').toggleClass('rotate-180', open);
    });
    function closeProfile() { $('#profileMenu').addClass('hidden'); $('#profileButton').attr('aria-expanded', 'false'); }
    $('#profileButton').on('click', function (event) {
        event.stopPropagation();
        const open = $('#profileMenu').hasClass('hidden');
        $('#profileMenu').toggleClass('hidden', !open);
        $(this).attr('aria-expanded', String(open));
    });
    $(document).on('click', function (event) { if (!$(event.target).closest('#profileMenu').length) closeProfile(); });
    $(document).on('keydown', function (event) { if (event.key === 'Escape') { closeNavigation(); closeProfile(); } });
});
