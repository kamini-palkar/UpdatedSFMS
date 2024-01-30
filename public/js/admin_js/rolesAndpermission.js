$('#role').on('change', function() {
    console.log('coming here');

    var url= $(this).attr('data-url');
    let role_id = $(this).val();
    // alert(url);
  
    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        data: {
          role_id: role_id,
          _token: "{{ csrf_token() }}"
        },
        success: function(data) {
            $('#fetch').html(data.html);
        },
       
    });
  });
  
      $(document).on('submit','#form',function() {
     
        console.log('in submit');
        var url = $(this).attr('data-url'); 
        
        let role_id = $(this).val();
        // alert(url);
  
        $.ajax({
          url: url,
          type: 'POST',
          data: {
          _token: "{{ csrf_token() }}",
           role_id:role_id
  
          },
          success: function(data) {
           console.log('hie');
          },
          error: function(xhr, status, error) {
            
            console.error(error);
          }
        });
      });
    