ClassicEditor
  .create( document.querySelector( '.field-textarea #Node_body' ) )
  .catch( error => {
    console.error( error );
  } );
