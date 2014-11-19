casper.test.begin('Accueil est present sur la page', 2, function suite(test) {
    casper.start("http://localhost/site-enseignant-chercheur/web/index.php?r=site", function() {
        test.assertTitle("Site enseignant chercheur", "titre correct");
        test.assertSelectorHasText('p', 'Accueil');
		
		var x = require('casper').selectXPath;
		this.click(x("//a[contains(@href, 'index&locale=en')]"));
    });
	
	casper.then(function() {
			var x = require('casper').selectXPath;

 this.waitUntilVisible(x("//a[contains(@href, 'index&locale=en')]"),
   function() { this.click(x("//a[contains(text(), 'Home')]")); 
    }
);
this.captureSelector('weather.png', 'body');
});




    casper.run(function() {
        test.done();
    });
});






casper.test.begin('CréationPublication', 3, function suite(test) {
    casper.start("http://localhost/site-enseignant-chercheur/web/index.php?r=publication/create", function() {
       this.test.assertTextExists('Create Publication', 'la page contient "create publication"');	
		 this.fill('form[action="/site-enseignant-chercheur/web/index.php?r=publication/create"]', { 
		 "Publication[reference]": 'SCZ13', 
			"Publication[auteurs]": 'roger',
			"Publication[titre]": 'test'			}, true);
		
	 this.click('button.btn-success'); 
    });
	
casper.then(function() {
		 this.test.assertTextExists('Date cannot be blank', 'la page contient le message d erreur pour une date vide');	

});


casper.then(function() {
this.fill('form[action="/site-enseignant-chercheur/web/index.php?r=publication/create"]', { 
		 "Publication[reference]": 'SCZ13', 
			"Publication[auteurs]": 'roger',
			"Publication[titre]": 'test',
			"Publication[date]": '2013-04-12'				}, true);
		
		
		
		
		//clic ne fonctionne pas
	this.evaluate(function() {
        $('input[type="submit"]:first').click();
    }); 
	 
});
casper.then(function() {

	 this.captureSelector('test.png', '.wrap');
	  //this.test.assertTextExists('roger', 'la page contient le nom d auteur entré précédemment');	
});


	


    casper.run(function() {
        test.done();
    });
});





