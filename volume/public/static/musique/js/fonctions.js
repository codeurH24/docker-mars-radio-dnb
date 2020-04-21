



		var activePlayer = function(identifiant, index)
		{
			
			//var audio = document.getElementById(source);
			var audios = document.getElementsByTagName('audio');
			var audio = audios[index];
			 
			
				 $(identifiant+' .play').on('click',function(e){ 
				  e.preventDefault(); 
				  audio.play(); 
				 });
				 
				 $(identifiant+' .pause').on('click',function(e){ 
				  e.preventDefault(); 
				  audio.pause(); 
				 });
				 
				 $(identifiant+' .stop').on('click',function(e){
				  e.preventDefault(); 
				  audio.pause(); 
				  audio.currentTime=0;
				 }); 		 
				 
				 $(identifiant+' .speed_plus').on('click',function(e){
				  e.preventDefault(); 
				  audio.playbackRate += 0.1; 
				 });  
				 
			

				 $(identifiant+' .speed_moins').on('click',function(e){
				  e.preventDefault(); 
				  audio.playbackRate -= 0.1; 
				 }); 		 
				 
				 $(identifiant+' .titreMusical').on('click',function(e){
				  e.preventDefault(); 
				 }); 
				 
				 var forceVolume = 1.0;
				 $(identifiant+'  .sonAudio').on('click',function(e){
						e.preventDefault();
						if( audio.volume > 0)
						{
							forceVolume = audio.volume;
							audio.volume = 0.0;
							 $(identifiant+' .sonAudio').css('background-position','32px 32px');
						}else
						{
							audio.volume = forceVolume;
							 $(identifiant+' .sonAudio').css('background-position','96px 32px');
						}
				 }); 
				 
				   var offset = function(el,event){
						var ox = -el.offsetLeft,
							oy = -el.offsetTop;
						while(el=el.offsetParent){
							ox += el.scrollLeft - el.offsetLeft;
							oy += el.scrollTop - el.offsetTop;
						}
						return {x:event.clientX + ox,y:event.clientY + oy};
					};
					  
				 $(identifiant+' .tempsTotal').click(function(e){
						e.preventDefault(); 
						var x = (e.pageX - this.offsetLeft);
						var y = e.pageY - this.offsetTop;
						
						var totalTime = parseInt(audio.duration);
						var tailleBar = $(identifiant+' .tempsTotal').width();
						
						var pos = offset(this,e);
						var coef = pos.x / tailleBar ;
						
						$('#debuggger').text( pos.x );
						audio.currentTime =  totalTime * coef; 

						
						
				   });
				   

				   
				   
				   //CONTROLE DU VOLUME
				   var SourisEnfoncer= false;
					$(identifiant+' .controleVolume').mousedown(function(e){
						e.preventDefault(); 
						SourisEnfoncer = true;
					});
					
					$(identifiant+' .controleVolume').mouseup(function(e){
						e.preventDefault(); 
						SourisEnfoncer = false;
					});


					
					$(identifiant+' .controleVolume').mousemove(function(e){
						e.preventDefault(); 
						if(SourisEnfoncer)
						{
						
						  var parentOffset = $(this).parent().offset(); 
						   //or $(this).offset(); if you really just want the current element's offset
						   var relX = e.pageX - parentOffset.left;
						   var relY = e.pageY - parentOffset.top;
						   relY = relY - 12;
						   relY = 51-relY
								
						
						
							var tailleBar = $(identifiant+' .controleVolume').height();
							var pos = offset(this,e);
							var positionSourisY = -210-(pos.y); /* -(tailleBar-6) */
							positionSourisY = positionSourisY % 50;
							//alert(positionSourisY+'-'+$(this).attr('id'));
							
							var coef = relY / tailleBar ;
							//coef = 2-coef;
							//alert(   coef           );
							audio.volume =  coef; 

							$(identifiant+' .controleVolume_statut').height( ( 50 - (coef* 50) ) );
							var volR = parseInt( 255 * coef );
							var volV = parseInt( 127 * coef );
							$(this).css('background-color',  'RGB('+volR+','+volV+',0)');
						}
						
				   });
				   
				 
				 
				 
				 

		}
		
		var  rafraichirPlayer = function( identifiant, index )
		{
			
			//audio = document.getElementById(source);
			var audios = document.getElementsByTagName('audio');
			var audio = audios[index];
			
			
					var timeEnCour = parseInt(audio.currentTime); 
					var totalTime = parseInt(audio.duration);
					
					var tailleBar = $(identifiant+' .tempsTotal').width();
					

						var coef = tailleBar / totalTime;
					
					
					
					tailleBarProgress = coef * timeEnCour ;
					
					//bar time
					 $(identifiant+' .tempsEnCour').css('width', parseInt(tailleBarProgress)+'px');
					
					// digital totalTime
					
					$(identifiant+' .affichageTempsTotal').text(totalTime);
					
					// digital Time
					$(identifiant+' .affichageTempsEnCour').text(timeEnCour);
					
					
					$(identifiant+' .widthBarProgress').text(parseInt(tailleBarProgress));
					
					if(audio.paused)
					{
						$(identifiant+' .etatPause').text('pause');
						$(identifiant+' .play').css('display', 'inline-block');
						$(identifiant+' .pause').css('display', 'none');
					}else
					{
						$(identifiant+' .etatPause').text('Lecture');
						$(identifiant+' .play').css('display', 'none');
						$(identifiant+' .pause').css('display', 'inline-block');
						
						

						
					}
					
					
					// Temps total en minute + seconde
					if( ! isNaN(audio.duration))
					{
						var timeMinute = audio.duration % 60 ; // recupere les seconde en trop
						var timeSeconde = parseInt(timeMinute);
						timeMinute = (audio.duration - timeMinute) / 60; // recupere les minute grace au seconde
						
						timeMinute = ("0" + timeMinute).slice(-2) ;
						timeSeconde = ("0" + timeSeconde).slice(-2) ;
						
						$(identifiant+' .time').text(timeMinute+' : '+timeSeconde);
					}
					// Temps lecture en cour en minute + seconde
					var timeMinute = audio.currentTime % 60 ; // recupere les seconde en trop
					var timeSeconde = parseInt(timeMinute);
					timeMinute = (audio.currentTime - timeMinute) / 60; // recupere les minute grace au seconde
					
					if( timeSeconde  < 10)
					{
						$(identifiant+' .time2').text(parseInt(timeMinute)+' : 0'+timeSeconde);
					}else
					{
						$(identifiant+' .time2').text(parseInt(timeMinute)+' : '+timeSeconde);
					}

					
					

		}