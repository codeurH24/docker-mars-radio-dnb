

class Player {
	constructor() {
		this.audio = null;
		this.SourisEnfoncer= false;
		this.interval_id = -1; 
		this.player = [];
		this.init = false;
		this.forceVolume = 1;
	}

	refresh(){
		if (this.audio.interval_id === undefined) {
			// console.log('refresh interval:', this.audio.interval_id);
			
			let audio = this.audio; 
			let id = this.currentPlayer.id;
			let interval_id;

			this.audio.interval_id = setInterval((e) => {
				// console.log(interval_id, id, 'timeEnCour', audio.currentTime, 'totalTime', audio.duration)
				this.UI_timers(id, audio);
				this.UI_progressBar(id, audio);
			}, 1000 );

			interval_id = this.audio.interval_id;
		}
	}

	UI_timers(id, audio){
		// Temps total en minute + seconde
		if( ! isNaN(audio.duration))
		{
			var timeMinute = audio.duration % 60 ; // recupere les seconde en trop
			var timeSeconde = parseInt(timeMinute);
			timeMinute = (audio.duration - timeMinute) / 60; // recupere les minute grace au seconde
			
			timeMinute = ("0" + timeMinute).slice(-2) ;
			timeSeconde = ("0" + timeSeconde).slice(-2) ;
			
			$('.time').eq(id).text(timeMinute+' : '+timeSeconde);
		}
		// Temps lecture en cour en minute + seconde
		var timeMinute = audio.currentTime % 60 ; // recupere les seconde en trop
		var timeSeconde = parseInt(timeMinute);
		timeMinute = (audio.currentTime - timeMinute) / 60; // recupere les minute grace au seconde
		
		if( timeSeconde  < 10)
		{
			$('.time2').eq(id).text(parseInt(timeMinute)+' : 0'+timeSeconde);
		}else
		{
			$('.time2').eq(id).text(parseInt(timeMinute)+' : '+timeSeconde);
		}
	}

	UI_progressBar(id, audio){

		var timeEnCour = parseInt(audio.currentTime); 
		var totalTime = parseInt(audio.duration);
		
		var tailleBar = $('.tempsTotal').eq(id).width();
		var coef = tailleBar / totalTime;
		var tailleBarProgress = coef * timeEnCour ;
		
		//bar time
		$('.tempsEnCour').eq(id).css('width', parseInt(tailleBarProgress)+'px');
		
		// digital totalTime
		
		$('.affichageTempsTotal').eq(id).text(totalTime);
		
		// digital Time
		$('.affichageTempsEnCour').eq(id).text(timeEnCour);
		
		
		$('.widthBarProgress').eq(id).text(parseInt(tailleBarProgress));

	}

	stop() {
		if (this.audio.interval_id !== undefined) {

			let id = this.currentPlayer.id;

			this.audio.pause(); 
			this.audio.currentTime=0;
			
			this.UI_progressBar(id, this.audio);
			this.UI_timers(id,this.audio);
			$('.etatPause').eq(id).text('pause');
			$('.play').eq(id).css('display', 'inline-block');
			$('.pause').eq(id).css('display', 'none')

			clearInterval(this.audio.interval_id);
			this.audio.interval_id = undefined;
			
		}
	}

	play() {
		this.audio.play(); 

		let id = this.currentPlayer.id;
		
		$('.etatPause').eq(id).text('Lecture');
		$('.play').eq(id).css('display', 'none');
		$('.pause').eq(id).css('display', 'inline-block');

		
	} 

	initEvent(event){
		
		
		if(this.init){
			event.preventDefault()
			return false;
		}
		else
			this.init = true;



		let that = this;
		// console.log('initEvent')
		$('.play').on('click',function(e){ 
			e.preventDefault(); 
			that.findAudioTag($(this));
			that.play();
			that.refresh();
		});
		$('.pause').on('click',function(e){ 
			e.preventDefault(); 
			that.findAudioTag($(this));
			that.audio.pause(); 

			let id = that.currentPlayer.id;
			$('.etatPause').eq(id).text('pause');
			$('.play').eq(id).css('display', 'inline-block');
			$('.pause').eq(id).css('display', 'none');

		});
		$('.stop').on('click',function(e){
			e.preventDefault(); 
			that.findAudioTag($(this));
			that.stop();
		});
		$('.speed_plus').on('click',function(e){
			e.preventDefault(); 
			let audio = that.findAudioTag($(this));
			audio.playbackRate += 0.1; 
		});
		$('.speed_moins').on('click',function(e){
			e.preventDefault();
			let audio = that.findAudioTag($(this));
			audio.playbackRate -= 0.1; 
		});

		$('.tempsTotal').click(function(e){
			e.preventDefault(); 

			that.findAudioTag($(this));
			let id = that.currentPlayer.id;

			var x = (e.pageX - this.offsetLeft);
			var y = e.pageY - this.offsetTop;
			
			var totalTime = parseInt(that.audio.duration);
			var tailleBar = $('.tempsTotal').eq(id).width();
			
			var pos = that.offset(this,e);
			var coef = pos.x / tailleBar ;
			
			// $('#debuggger').text( pos.x );
			that.audio.currentTime =  totalTime * coef; 

			that.UI_progressBar(id, that.audio);
	   });

	   $('.sonAudio').on('click',function(e){
			e.preventDefault();
			that.findAudioTag($(this));
			let id = that.currentPlayer.id;

			if( that.audio.volume > 0) {
				that.forceVolume = that.audio.volume;
				that.audio.volume = 0.0;
				$('.sonAudio').eq(id).css('background-position','32px 32px');
			} else {
				that.audio.volume = that.forceVolume;
				$('.sonAudio').eq(id).css('background-position','');
			}
		}); 



		//CONTROLE DU VOLUME
		$('.controleVolume').mousedown(function(e){
			e.preventDefault(); 
			that.SourisEnfoncer = true;
			if (that.audio === null) {
				that.audio = that.findAudioTag($(this));
			}
		});

		$('.controleVolume').mouseleave(function(e){
			e.preventDefault(); 
			that.SourisEnfoncer = false;
			// that.audio = null;
		});
		
		$('.controleVolume').mouseup(function(e){
			e.preventDefault(); 
			that.SourisEnfoncer = false;
			// that.audio = null;
		});


		
		$('.controleVolume').mousemove(function(e){
			e.preventDefault(); 
			if(that.SourisEnfoncer && that.audio !== null && that.audio !== undefined)
			{

				that.findAudioTag($(this));
				let id = that.currentPlayer.id;	
			
				var parentOffset = $(this).parent().offset(); 
				//or $(this).offset(); if you really just want the current element's offset
				var relX = e.pageX - parentOffset.left;
				var relY = e.pageY - parentOffset.top;
				relY = relY - 12;
				relY = 55-relY
					


				var tailleBar = $(this).height();
				var pos = that.offset(this,e);
				var positionSourisY = -210-(pos.y); /* -(tailleBar-6) */
				positionSourisY = positionSourisY % 50;
				//alert(positionSourisY+'-'+$(this).attr('id'));

				var coef = relY / tailleBar ;
				//coef = 2-coef;
				//alert(   coef           );
				// console.log(coef);

				if(coef > 1) coef = 1 

				that.audio.volume =  coef; 

				$('.controleVolume_statut').eq(id).height( ( 50 - (coef* 50) ) );
				var volR = parseInt( 255 * coef );
				var volV = parseInt( 127 * coef );
				$(this).css('background-color',  'RGB('+volR+','+volV+',0)');
			}
			
		});
		

	}

	offset(el,event){
		var ox = -el.offsetLeft,
			oy = -el.offsetTop;
		while(el=el.offsetParent){
			ox += el.scrollLeft - el.offsetLeft;
			oy += el.scrollTop - el.offsetTop;
		}
		return {x:event.clientX + ox,y:event.clientY + oy};
	};

	/**
	 * 
	 * @param {*} audioElm Element enfant jquery du container parent de la balise audio
	 */
	findAudioTag(audioElm) {
		var elmFound = audioElm
		var id = -1;
		for (let index = 0; index < 10; index++) {
			// incrémente de parent en parent à chaque boucles
			elmFound = elmFound.parent();
			// mémorise le resultat de find pour optimiser les performances
			var elmTmp = elmFound.find('audio');
			// si un element à été trouvé alors
			// le premier element trouvé est forcément la tag recherché.
			if (elmTmp.length) {
				id = $( "audio" ).index(  elmTmp );
				elmFound = elmTmp[0];
				break;
			}
		}

		let isPlayerExiste = false;

		this.player.forEach(element => {
			if (id == element.id ) {
				isPlayerExiste = true;
				this.audio = element.audio
				this.currentPlayer = element;
				// console.log('audio', id , 'retrouvé');
				return;
			}
		});

		if (!isPlayerExiste) {

			// console.log('audio', id , 'trouvé');
			this.player.push({id, audio:elmFound});
			this.audio = elmFound
			this.currentPlayer = {id, audio:elmFound};
		}

		return elmFound;
	}
}
