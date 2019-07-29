<footer>
        <p>Twitter API test for iTech Media: Mauricio Masias - <a href="https://www.linkedin.com/in/mauriciomasias/" target="_blank">LinkedIn</a> </p>
</footer>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script>var ajaxurl = '{{ url('/check-new-tweets') }}';var token = '<?php echo csrf_token(); ?>'</script>
<script src="{{ asset('js/app.js') }}"></script>