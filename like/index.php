<button onclick="like()">
like
</button>
<p id="count"></p>

<script>
    function like(){
        var req = new XMLHttpRequest();
        var count = document.querySelector('#count');
        req.onreadystatechange = function(){
            if(req.readyState == 4 && req.status ==200){
                count.innerHTML =req.responseText;
        }
    }
    req.open('GET','like.php');
    req.send();
    }
    
</script>