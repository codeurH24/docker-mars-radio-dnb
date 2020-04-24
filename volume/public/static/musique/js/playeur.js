// juste avant de cliquer sur play du lecteur
// on recupere le nombre de lecteur et le compare a celui qui est survoler
// une fois comparer cela nos retourne son index (celui survoler)
// le playeur survoler pour la premier fois (juste le bouton play) active le script pour la gestion
// des fonctions du lecteur (play, pause, stop, etc ...) 
// Les autres lecteur ne son pas pris en compte tant que le survole a la souris n'est pas fait
// au moins une fois
$('.play').on('mouseenter',function(e){ 
	e.preventDefault(); 
	// var linkList = $("body").find(".lecteur"); // liste les elements
	// var index = linkList.index($(this).parent()); // retourne l'index de ce element parmis la liste
	// activePlayer('.lecteur:eq('+ index +')', index );
	// activePlayer2($(this));
	
	(new player).initEvent();
	
	// setInterval(function(e){
	// 	rafraichirPlayer('.lecteur:eq('+ index +')', index ); // gere et affiche les infos du lecteur
	// }, 40 );	
	
	// activePlayer pourrait est inclus dans la fonction initMetaDataPlayeur
	//  a la place de creer cette fonction mouseenter
});


// met a jour les informations des playeur d�s le chargement de la page
// active pour chaque lecteur l'affichage en temps reel grace a setInterval de la fonction rafraichirPlayer
// setInterval de la fonction initMetaDataPlayeur sert quand a elle a attendre le preload reel de chaque audio.
var initMetaDataPlayeur = function(){
	var indice = 0; // correspond a l'index "DOM element" audio
	var intervalId = setInterval(function(e) // boucle qui reverifie si audio.duration n'est pas NaN
	{
		
		var list_balises_audios = document.getElementsByTagName('audio'); // liste les balise audio sur la page html
		var audio = list_balises_audios[indice]; // recupere la n'ieme balise audio dans audio

		try {
			//console.log(indice +' > '+audio.duration);//montre que la duration est  NaN ou numerique
			
			if(! isNaN( audio.duration )   )//montre que la duration n'est pas NaN
			{
				rafraichirPlayer('.lecteur:eq('+ indice +')', indice ); // gere et affiche les infos du lecteur
				$('.lecteur:eq('+ indice +') .tempsTotal').css("background-image", "none"); //supprime le barre de chargement
				indice = indice +1; // on travaille sur l'audio suivant
			}	
		}
		catch(err) { // si duration est erreur de javascript.
			//console.log('erreur');
			
			indice = 0; // remet a jour chaque affichage des lecteurs
			// car l'audio zero jusqua N audio a ete precharger au moins une fois.
			// la fonction rafraichirPlayer doit etre rappeler pour mettre a jour en temps reel l'affichage
			// du lecteur qui avance dans le temps etc...
			
			//clearInterval(intervalId); // Stop interval
		}
	},40);
	
	
	
	
}
initMetaDataPlayeur();


















/*
	var initMetaDataPlayeur = function(indice){
	var list_balises_audios = document.getElementsByTagName('audio'); 
	var audio = list_balises_audios[indice];
	

	
	audio .addEventListener('loadedmetadata', function() {
				
		// une fois charger on enleve la barre de prograssion gif
		$('.lecteur:eq('+ indice +') .tempsTotal').css("background-image", "none");
				
		// rafraichisement de l'affichage du lecteur
		setInterval(function(e)
		{
			rafraichirPlayer('.lecteur:eq('+ indice +')', indice );
		},40); // boucle de 0.040 seconde
		
		// la fonction recursive continue tant qu'ont a pas fait chaque balise audio
		if( indice < list_balises_audios.length )
		{
			initMetaDataPlayeur(indice+1); // fonction recurcive
		}
				
	});
}
*/
//initMetaDataPlayeur(0);