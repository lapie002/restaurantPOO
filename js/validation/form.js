    function validate()
    {
        /* soit on met dans des variable soit on recup avec un id: document.getElementById, soit avec le name: document.myForm.title.focus();*/  
        var t = document.getElementById('title').value;
        var d = document.getElementById('text').value;
        var p = document.getElementById('price').value;
        var px = parseFloat(document.getElementById('price').value);
        var prdtD = document.getElementById('productDate').value;
        
        var rawDate = prdtD;
        var maDate = rawDate.toString();
        
        // Parse the date parts to integers
        var parts = maDate.split('-');
     
        var d = parseInt(parts[2], 10);
        var m = parseInt(parts[1], 10);
        var y = parseInt(parts[0], 10);


        if( t == "" || t == null )
        {
            alert( "Please provide a title for the product!" );
            document.myForm.title.focus();
            return false;
        }
       
        if( document.getElementById('text').value == "" )
        {
            alert( "Please provide a product description!" );
            document.myForm.text.focus();
            return false;
        }
        
        if( isNaN(px) || px < 0 )
        {
            alert("Please enter a valide numeric value for a product price! (Allowed input: positive numbers only).");
            document.myForm.price.focus();
            return false;
        }
        
        if( y < 1000 || y > 3000 || m == 0 || m > 12 )
        {
            alert("Please enter a valide date for the product!");
            document.myForm.productDate.focus();
            return false;
        }
        
        return true;
    }
