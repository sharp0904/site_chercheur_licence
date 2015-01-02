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
});




    casper.run(function() {
        test.done();
    });
});






casper.test.begin('CreationPublication', 3, function suite(test) {
    casper.start("http://localhost/site-enseignant-chercheur/web/index.php?r=publication/create", function() {
       this.test.assertTextExists('Create Publication', 'la page contient "create publication"');	
		 this.fill('form[action="/site-enseignant-chercheur/web/index.php?r=publication/create"]', { 
		 "Publication[reference]": 'SCZ13', 
			"Publication[auteurs]": 'roger',
			"Publication[titre]": 'test'			}, true);
		
    });
	
casper.then(function() {
	 this.captureSelector('test1.png', '.wrap');

		 this.test.assertTextExists('Date cannot be blank', 'la page contient le message d erreur pour une date vide');	

});


casper.then(function() {
var aujourd_hui = new Date();
 
 var ref = 'SCZ13';
 var auteur = 'robert';
 var date_ajourdhui = aujourd_hui.getFullYear() + '-' + aujourd_hui.getMonth() + '-' + aujourd_hui.getDate();
 var titre = 'testTitre';
 var journal = 'la montagne';
this.fill('form[action="/site-enseignant-chercheur/web/index.php?r=publication/create"]', { 
		 
		 "Publication[reference]": ref, 
			"Publication[auteurs]": auteur,
			"Publication[date]": date_ajourdhui,

			"Publication[titre]": titre,
			
			"Publication[journal]": journal,			}, true);
		
		
			 this.captureSelector('test2.png', '.wrap');

		casper.open('http://localhost/site-enseignant-chercheur/web/index.php?r=publication/create', {
    method: 'post',
    data:   {
        'reference': ref,
        'auteurs':  auteur,
		'date' : date_ajourdhui,
		'titre' : titre,
		'journal':journal
    }
		

	});

});
casper.then(function() {

	 this.captureSelector('test3.png', '.wrap');


	  this.test.assertTextExists('robert', 'la page contient le nom d\'auteur entré précédemment');	
});

	


    casper.run(function() {
        test.done();
    });
});


casper.test.begin('PageNotFound + tri publication', 5, function suite(test) {
    casper.start("http://localhost/site-enseignant-chercheur/web/index.php?r=site/index&page=abc", function() {
       this.test.assertTextExists('Not found', 'la page abc est inexistante et affiche le message correspondant en Anglais');
    });
	
casper.thenOpen('http://localhost/site-enseignant-chercheur/web/index.php?r=site/publications', function() {

	var x = require('casper').selectXPath;
		this.click(x("//a[contains(@href, 'date')]"));


});	
casper.then(function() {

	  this.test.assertTextExists('2014', 'les publications sont bien triées par date');
	  var x = require('casper').selectXPath;
		this.click(x("//a[contains(@href, 'tri=cat')]"));
		

	 
});

casper.then(function() {

			 this.test.assertTextExists('testFR', 'les publications sont bien triées par catégorie'); 
});
	
	
	

casper.thenOpen('http://localhost/site-enseignant-chercheur/web/index.php?r=site/login', function() {
var username = 'SCZ13';
 var password = '';
 
this.test.assertTextExists('Login', 'la page contient "Login"');	
		 this.fill('form[action="/site-enseignant-chercheur/web/index.php?r=site/login"]', { 
		 "LoginForm[username]": username, 
			"LoginForm[password]": password
						}, true);
						
		



		casper.open('http://localhost/site-enseignant-chercheur/web/index.php?r=site/login', {
    method: 'post',
    data:   {
        'username': username,
        'password':  password,
		
    }
	});
	
	this.test.assertTextExists('Password cannot be blank', 'la page affiche un message d\'erreur si le password est vide');	
			 this.captureSelector('testLogin.png', '.wrap');

	
	
	


});	

casper.thenOpen('http://localhost/site-enseignant-chercheur/web/index.php?r=site/login',function() {

var username = 'demo';
 var password = 'demo';
 
 this.fill('form[action="/site-enseignant-chercheur/web/index.php?r=site/login"]', { 
		 "LoginForm[username]": username, 
			"LoginForm[password]": password
						}, true);
	
	
	
	 				 this.captureSelector('testLogout.png', '.wrap');

});

//il manque les tests sur rubriques et menu 
//Création d'une page et puis thenOpen et on teste si la page est présente et on teste sa traduction




casper.run(function() {
        test.done();
    });
});




