// juste avant de cliquer sur play du lecteur
// on recupere le nombre de lecteur et le compare a celui qui est survoler
// une fois comparer cela nos retourne son index (celui survoler)
// le playeur survoler pour la premier fois (juste le bouton play) active le script pour la gestion
// des fonctions du lecteur (play, pause, stop, etc ...) 
// Les autres lecteur ne son pas pris en compte tant que le survole a la souris n'est pas fait
// au moins une fois
let player = new Player();

$('.play').on('mouseenter',function(e){ 
	e.preventDefault(); 
	player.initEvent(e);
});
