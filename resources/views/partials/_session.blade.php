<!-- Notyfication plugins -->

@if (session('success'))

    <script>

        new Noty({

            theme: 'metroui',
            type: 'success',
            layout: 'topRight',
            text: "{{ session('success') }}",
            timeout: 2500,
            killer: true

        }).show();

    </script>

<script src="https://www.gstatic.com/firebasejs/3.7.2/firebase.js"></script>

<script>
            var notification = new Notification("{{ auth()->user()->first_name }}", {
                    icon: "{{ auth()->user()->image_path }}",
                    body: "{{ session('success') }}",
                });
                notification.onclick = function() {
                    window.open('{{ route('dashboard.index') }}');
                };
</script>
@endif

