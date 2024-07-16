    <div class="appBottomMenu">
        <a href="index.html" class="item active">
            <div class="col">
                <ion-icon name="pie-chart-outline"></ion-icon>
                <strong>Overview</strong>
            </div>
        </a>
        <a href="app-pages.html" class="item">
            <div class="col">
                <ion-icon name="document-text-outline"></ion-icon>
                <strong>Pages</strong>
            </div>
        </a>
        <a href="app-components.html" class="item">
            <div class="col">
                <ion-icon name="apps-outline"></ion-icon>
                <strong>Components</strong>
            </div>
        </a>
        <a href="app-cards.html" class="item">
            <div class="col">
                <ion-icon name="card-outline"></ion-icon>
                <strong>My Cards</strong>
            </div>
        </a>
        <a href="app-settings.html" class="item">
            <div class="col">
                <ion-icon name="settings-outline"></ion-icon>
                <strong>Settings</strong>
            </div>
        </a>
    </div>
    <!-- * App Bottom Menu -->
    <script src="{{asset('public')}}/assets/js/lib/bootstrap.bundle.min.js"></script>
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <!-- Splide -->
    <script src="{{asset('public')}}/assets/js/plugins/splide/splide.min.js"></script>
    <!-- Base Js File -->
    <script src="{{asset('public')}}/assets/js/base.js"></script>

    <script>
        // Add to Home with 2 seconds delay.
        AddtoHome("2000", "once");
    </script>

</body>
if (response.status == true) {
    $("#name").removeClass('is-invalid').siblings('p').removeClass(
        'invalid-feedback').html('');
    $("#rate").removeClass('is-invalid').siblings('p').removeClass(
        'invalid-feedback').html('');
    $("#tax").removeClass('is-invalid').siblings('p').removeClass(
        'invalid-feedback').html('');
    // {{-- window.location.href = "/account/my-jobs"; --}}
} else {
    var errors = response.errors;

    if (errors.name) {
            $("#name").focus();
                }, 100);
        $("#name").addClass('is-invalid').siblings('p').addClass(
            'invalid-feedback').html(errors.name);
    } else {
        $("#name").removeClass('is-invalid').siblings('p').removeClass(
            'invalid-feedback').html('');
    }
    if (errors.rate) {
        setTimeout(function() {
            $("#rate").focus();
                }, 100);
        $("#rate").addClass('is-invalid').siblings('p').addClass(
            'invalid-feedback').html(errors.rate);
    } else {
        $("#rate").removeClass('is-invalid').siblings('p').removeClass(
            'invalid-feedback').html('');
    }
    if (errors.tax) {
        setTimeout(function() {
            $('#tax').focus();
                }, 100);
        $("#tax").addClass('is-invalid').siblings('p').addClass(
            'invalid-feedback').html(errors.location);
    } else {
        $("#tax").removeClass('is-invalid').siblings('p').removeClass(
            'invalid-feedback').html('');
    }
}
}
</html>
