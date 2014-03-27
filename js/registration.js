(function () {

// ## getData
// Gets data out of form and returns it
function getData () {
  return $('#regform').serializeArray().reduce(function (memo, item) {

    memo[item.name] = item.value;

    return memo;
  }, {});
}

function register () {
  Parse.initialize("hekpb4HEDmzg9XTFmKZ3Nnq9JXCO00etDfns9xlV", "h8VJFlFDwWEZN2wGx8dkf2mtTPh0qtblxaLEbTa6");

  $('#submitbtn').attr('disabled', true);
  $('#submitbtn').attr('value', 'Registering ...');

  var reg = Parse.Object.extend("registration");

  var user = new reg();
  var data = getData();

  for (var i in data) user.set(i, data[i]);

  function __doSignup (resumeFile) {
    console.log(resumeFile);
    if (resumeFile) user.set('resume', resumeFile);

    user.save().then(function () {
      alert("You've been signed up successfully!", "http://hackru.org");

      $('#submitbtn').attr('disabled', false);
      $('#submitbtn').attr('value',  'Register');
    }, function (error) {
      alert(error.message);

      $('#submitbtn').attr('disabled', false);
      $('#submitbtn').attr('value',  'Register');
    });
  }

  var filecontrol = $('#upfile')[0];
  var filename = $('#upfile').value;
  var parseFile;

  try {

    if (filecontrol.files.length > 0) {
      var file = filecontrol.files[0];
      var name = data.username.replace(/ /g, '') + "_resume";

      var parts = file.name.split('.');
      var ext = parts[parts.length - 1].toUpperCase();
      if (ext !== "PDF") {
        $('#submitbtn').attr('disabled', false);
        $('#submitbtn').attr('value', 'Register');
        return alert("Resume must be .pdf file");
      }

      parseFile = new Parse.File(name, file);
    } else {
      return alert("Resume is required");
    }

  } catch (e) { 
    /* do nothing if the file shit doesnt work */
    console.log(e);
    alert("Resume is required");
  } finally {
  }

  __doSignup(parseFile);
}

$('#regform').on('submit', function (e) {
  e.preventDefault();

  register();
});

window.getData = getData;
window.register = register;

var inst = $.remodal.lookup[$('[data-remodal-id=modal]').data('remodal')];

alert = function (stuff, redirect) {
  $('#remodal p').html(stuff);
  inst.open();

/*
  if (redirect) {
    $(document).on('closed', '.remodal', function () {
      window.location = redirect;
    });
  }
  */
};

}());
