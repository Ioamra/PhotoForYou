<footer class="text-center">
    Mail : iom.monchau@gmail.com 
    <br>
    © Fait par Ioamra Monchau
</footer>

<script type="text/javascript">

//* Gestion navbar page active
var current = window.location.href.split('?')[0];
var val = document.getElementsByTagName('a');
for (i = 0; i < val.length; i++) {
    if (val[i].className == "nav-link") {
        if (val[i].href.indexOf(current) != -1) {
            val[i].className = "nav-link active";
        }
    }
}
</script>
