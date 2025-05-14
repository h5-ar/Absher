<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div {{ $attributes->merge(['class' => 'content-wrapper container-xxl p-0']) }}>
        {{ $slot }}
    </div>
</div>
