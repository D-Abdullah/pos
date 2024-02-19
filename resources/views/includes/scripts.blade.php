<script src="{{ asset('Assets/JS files/global.js') }}"></script>
<script src="{{ asset('Assets/JS files/dropdown.js') }}"></script>
<script src="{{ asset('Assets/JS files/all.min.js') }}"></script>

<script>
    document.getElementById('logout').addEventListener('click', function() {
        // console.log()
        fetch("{{ route('logout') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
            })
            .then(response => {
                if (response.ok) {
                    window.location.href = "{{ route('login') }}";
                } else {
                    console.error('Logout failed');
                }
            })
            .catch(error => {
                console.error('Fetch error:', error);
            });
    });
</script>

@yield('script')