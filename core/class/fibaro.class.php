<?php

/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

/* * ***************************Includes********************************* */
require_once __DIR__  . '/../../../../core/php/core.inc.php';

class fibaro extends eqLogic {
    /*     * *************************Attributs****************************** */



    /*     * ***********************Methode static*************************** */

   
     /* Fonction exécutée automatiquement toutes les minutes par Jeedom
      public static function cron() {
      
        //recuperation de IP, Login, Mdp  (parametre Global de module)
      	$fibaroIP = config::byKey('fibaroIP', 'fibaro', 'none');
      	$fibaroLogin = config::byKey('fibaroLogin', 'fibaro', 'none');
      	$fibaroLogin = urlencode($fibaroLogin);
      	$fibaroMDP = config::byKey('fibaroMDP', 'fibaro', 'none');
        
      
      // Récupère la liste des équipements
    if ($_eqLogic_id == null)
    {
        $eqLogics = self::byType('fibaro', true);
    } 
    else
    {
        $eqLogics = array(self::byId($_eqLogic_id));
    }
        
        // Met à jour l'ensemble des équipements
    foreach ($eqLogics as $fibaroObj)
    {
		
      	
   		//$eqLogic = $this->getEqLogic();
      	$idModule = $fibaroObj->getConfiguration('fibaroIdModule');
       	//log::add('fibaro', 'debug', 'Cron IdModule:'.$idModule);
      
      	 //recuperation de json de module
      	$json_source = file_get_contents("http://$fibaroLogin:$fibaroMDP@$fibaroIP/api/devices?id=$idModule"); 
      	//traitement de json
      	$json_data = json_decode($json_source);
      	//exploitation des variables json
      	$Type = $json_data->type;
      
      	$Nom = $json_data->name;
     	if(!isset($json_data->{'properties'}->{'value'})) {$Etatt =''; } else {$Etatt = $json_data->{'properties'}->{'value'};}
      	if(!isset($json_data->{'properties'}->{'power'})) {$Power =''; } else {$Power = $json_data->{'properties'}->{'power'};}
      	if(!isset($json_data->{'properties'}->{'armed'})) {$Armed =''; } else {$Armed = $json_data->{'properties'}->{'armed'};}
      
      
         // On récupère la commande 'etat' appartenant à l'équipement
        $cmdEtat = $fibaroObj->getCmd('info', 'etat');
        // On lui ajoute un évènement avec pour information '$Etatt'
        $cmdEtat->event($Etatt);
        // On sauvegarde cet évènement
        $cmdEtat->save();
      	//log::add('fibaro', 'debug', 'Cron etat:'.$Etatt);

    }

      }*/
     


    /*
     * Fonction exécutée automatiquement toutes les heures par Jeedom
      public static function cronHourly() {

      }
     */

    /*
     * Fonction exécutée automatiquement tous les jours par Jeedom
      public static function cronDaily() {

      }
     */



    /*     * *********************Méthodes d'instance************************* */

    public function preInsert() {
        
    }

    public function postInsert() {
        
    }

    public function preSave() {
      
      //recuperation de ID de module Fibaro (parametre de module)
      $fibaroIdModule = $this->getConfiguration("fibaroIdModule");
      
      //recuperation de IP, Login, Mdp  (parametre Global de module)
      $fibaroIP = config::byKey('fibaroIP', 'fibaro', 'none');
      $fibaroLogin = config::byKey('fibaroLogin', 'fibaro', 'none');
      $fibaroLogin = urlencode($fibaroLogin);
      $fibaroMDP = config::byKey('fibaroMDP', 'fibaro', 'none');
      $fibaroMDP = urlencode($fibaroMDP);  
      
      //recuperation de json de module
      $json_source = file_get_contents("http://$fibaroLogin:$fibaroMDP@$fibaroIP/api/devices?id=$fibaroIdModule"); 
      //traitement de json
      $json_data = json_decode($json_source);
      //exploitation des variables json
      $Type = $json_data->type;
      
      //$icone='';
      switch ($Type) {
          
          case "com.fibaro.binarySwitch": //Interupteur On/Off + Nodon
            $icone='light.png';
          break;
          //---
          case "com.fibaro.FGWP101": //Wallplug FGWP101
	  case "com.fibaro.FGWP102": //Wallplug FGWP102	   
          $icone='wallplug.png';
          break;
          //---
          case "com.fibaro.temperatureSensor": //temperature
          	$icone='Tmp.png';
          break;
          //---
          case "com.fibaro.humiditySensor": //humidité
          $icone='humidity.png';
          break;
          //---
          case "com.fibaro.lightSensor": //Luxmètre
          $icone='lux.png';
          break;
          //---
          case "com.fibaro.FGRM222": //volets
	  case "com.fibaro.FGR223":
          $icone='store.png';
          break;
          //---
          case "com.fibaro.multilevelSwitch": //dimmer
          case "com.fibaro.FGD212": 
          $icone='dimmer.png';
          break;
          //---
          case "com.fibaro.doorSensor": //detecteur ouverture
          case "com.fibaro.windowSensor": //detecteur ouverture
          $icone='opening.png';
          break;
          //--- 
          case "com.fibaro.FGMS001": //detecteur de mouvment
          case "com.fibaro.FGMS001v2": //detecteur de mouvment v2
          $icone='motion.png';
          break;
          //--- 
          case "com.fibaro.motionSensor": //detecteur de mouvment 
          case "com.fibaro.satelZone": //detecteur de mouvment capteurs d'alarme Satel
          $icone='motion2.png';
          break;
          //---
          case "com.fibaro.FGSS001": //detecteur de fumé 
          case "com.fibaro.FGCD001": //detecteur de CO2
          $icone='smoke_sensor0.png';
          break;
          //---
          case "com.fibaro.FGFS101": //detecteur d'innondation
          $icone='flood_detector0.png';
          break;
          //--- 
          
          
      }
		$this->setConfiguration('icone' , $icone);
    }
  
  	public function getImage() {

      	return 'plugins/fibaro/desktop/icones/' . $this->getConfiguration('icone' , 'fibaro_icon.png');

      
	}

    public function postSave() {
      //recuperation de ID de module Fibaro (parametre de module)
      $fibaroIdModule = $this->getConfiguration("fibaroIdModule");
      
      //recuperation de IP, Login, Mdp  (parametre Global de module)
      $fibaroIP = config::byKey('fibaroIP', 'fibaro', 'none');
      $fibaroLogin = config::byKey('fibaroLogin', 'fibaro', 'none');
      $fibaroLogin = urlencode($fibaroLogin);
      $fibaroMDP = config::byKey('fibaroMDP', 'fibaro', 'none');
      $fibaroMDP = urlencode($fibaroMDP);  
      
      //recuperation de json de module
      $json_source = file_get_contents("http://$fibaroLogin:$fibaroMDP@$fibaroIP/api/devices?id=$fibaroIdModule"); 
      //traitement de json
      $json_data = json_decode($json_source);
      //exploitation des variables json
      $Type = $json_data->type;
      
      $Nom = $json_data->name;
      if(!isset($json_data->{'properties'}->{'value'})) {$Etatt =''; } else {$Etatt = $json_data->{'properties'}->{'value'};}
      if(!isset($json_data->{'properties'}->{'power'})) {$Power =''; } else {$Power = $json_data->{'properties'}->{'power'};}
      if(!isset($json_data->{'properties'}->{'armed'})) {$Armed =''; } else {$Armed = $json_data->{'properties'}->{'armed'};}
            
      
      //Creation des commandes en fonction du type
  
		switch ($Type) {
          
          case "com.fibaro.binarySwitch": //Interupteur On/Off + Nodon
          case "com.fibaro.FGWP101": //Wallplug
	  case "com.fibaro.FGWP102": //Wallplug 2
               
            
            //On
            $cmdOn = $this->getCmd(null, 'on');

            if (!is_object($cmdOn)) {             
              $cmdOn = new fibaroCmd();
              $cmdOn->setName(__('ON', __FILE__)); 
              
            }
			  
              $cmdOn->setLogicalId('on');
              $cmdOn->setEqLogic_id($this->getId());
              $cmdOn->setOrder(1);
              $cmdOn->setIsVisible(1);
              $cmdOn->setValue('ON');
              $cmdOn->setType('action');
              $cmdOn->setSubType('other');
              $cmdOn->save();
            
            //Off
            $cmdOff = $this->getCmd(null, 'off');

            if (!is_object($cmdOff)) {             
              $cmdOff = new fibaroCmd();
              $cmdOff->setName(__('OFF', __FILE__)); 
              
            }
			  $cmdOff->setLogicalId('off');
              $cmdOff->setEqLogic_id($this->getId());
              $cmdOff->setOrder(2);
              $cmdOff->setIsVisible(1);
              $cmdOff->setValue('OFF');
              $cmdOff->setType('action');
              $cmdOff->setSubType('other');
              $cmdOff->save();
            
            //Etat
           	$cmdEtat = $this->getCmd(null, 'etat');

            if (!is_object($cmdEtat)) {
              $cmdEtat = new fibaroCmd();
			  $cmdEtat->setName(__('Etat', __FILE__));
              $cmdEtat->setTemplate('dashboard','light' );
              $cmdEtat->setTemplate('mobile', 'light');
            }
			  $cmdEtat->setLogicalId('etat');
              $cmdEtat->setEqLogic_id($this->getId());
              $cmdEtat->setOrder(0);
              $cmdEtat->setIsVisible(1);
              $cmdEtat->setValue('Etat');
              $cmdEtat->setType('info');
			  $cmdEtat->setSubType('binary');            
              $cmdEtat->save(); 
            
            //Refresh
            $getDataCmd = $this->getCmd(null, 'refresh');
        if (!is_object($getDataCmd))
        {
            // Création de la commande Rafraichir
            $cmd = new fibaroCmd();
            // Nom affiché
            $cmd->setName('Rafraichir');
            // Identifiant de la commande
            $cmd->setLogicalId('refresh');
            // Identifiant de l'équipement
            $cmd->setEqLogic_id($this->getId());
            // Type de la commande
            $cmd->setType('action');
            // Sous-type de la commande
            $cmd->setSubType('other');
            // Visibilité de la commande
            $cmd->setIsVisible(1);
            // Sauvegarde de la commande
            $cmd->save();
        }
            
            //Type
           /*	$cmdEtat = $this->getCmd(null, 'type');

            if (!is_object($cmdEtat)) {
              $cmdEtat = new fibaroCmd();
			  $cmdEtat->setName(__('type', __FILE__));
            }
			  $cmdEtat->setLogicalId('type');
              $cmdEtat->setEqLogic_id($this->getId());
              $cmdEtat->setOrder(0);
              $cmdEtat->setIsVisible(1);
              $cmdEtat->setType('info');
			  $cmdEtat->setSubType('string'); 
              $cmdEtat->setValue($Type);
              $cmdEtat->save(); */
		                      
              break;
          //---
          case "com.fibaro.temperatureSensor": //temperature
            
            
			//temperature
           	$cmdT = $this->getCmd(null, 'temperature');

            if (!is_object($cmdT)) {
              $cmdT = new fibaroCmd();
			  $cmdT->setName(__('Température', __FILE__));
              $cmdT->setTemplate('dashboard','tile' );
              $cmdT->setTemplate('mobile', 'tile');
              
            }
			 $cmdT->setLogicalId('temperature');
              $cmdT->setEqLogic_id($this->getId());
              $cmdT->setOrder(1);
              $cmdT->setIsVisible(1);
              $cmdT->setValue('Temperature');
              $cmdT->setType('info');
			  $cmdT->setSubType('numeric');
              // on defini l'unité
          	  $cmdT->setUnite('°C');
              $cmdT->save(); 
            
            //Refresh TMP
            $cmdTR = $this->getCmd(null, 'refresh');
        if (!is_object($cmdTR))//$getDataCmd
        {
            // Création de la commande Rafraichir
            $cmdTR = new fibaroCmd();
            // Nom affiché
            $cmdTR->setName('RafraichirTmp');
            // Identifiant de la commande
            $cmdTR->setLogicalId('refresh');
            // Identifiant de l'équipement
            $cmdTR->setEqLogic_id($this->getId());
            // Type de la commande
            $cmdTR->setType('action');
            // Sous-type de la commande
            $cmdTR->setSubType('other');
            // Visibilité de la commande
            $cmdTR->setIsVisible(1);
            // Sauvegarde de la commande
            $cmdTR->save();
        }
            
          break;
            
        case "com.fibaro.humiditySensor": //humidité
            
            
			//humidité
           	$cmdT = $this->getCmd(null, 'humidite');

            if (!is_object($cmdT)) {
              $cmdT = new fibaroCmd();
			  $cmdT->setName(__('Humidité', __FILE__));
              //$cmdT->setTemplate('dashboard','tile' );
              //$cmdT->setTemplate('mobile', 'tile');
              
            }
			 $cmdT->setLogicalId('humidite');
              $cmdT->setEqLogic_id($this->getId());
              $cmdT->setOrder(1);
              $cmdT->setIsVisible(1);
              $cmdT->setValue('Humidite');
              $cmdT->setType('info');
			  $cmdT->setSubType('numeric');
              // on defini l'unité
          	  $cmdT->setUnite('%');
              $cmdT->save(); 
            
            //Refresh Humidité
            $cmdTR = $this->getCmd(null, 'refresh');
        if (!is_object($cmdTR))//$getDataCmd
        {
            // Création de la commande Rafraichir
            $cmdTR = new fibaroCmd();
            // Nom affiché
            $cmdTR->setName('RafraichirHum');
            // Identifiant de la commande
            $cmdTR->setLogicalId('refresh');
            // Identifiant de l'équipement
            $cmdTR->setEqLogic_id($this->getId());
            // Type de la commande
            $cmdTR->setType('action');
            // Sous-type de la commande
            $cmdTR->setSubType('other');
            // Visibilité de la commande
            $cmdTR->setIsVisible(1);
            // Sauvegarde de la commande
            $cmdTR->save();
        }
            
          break;
            
        case "com.fibaro.lightSensor": //Luxmètre
            
			//Luxmètre
           	$cmdT = $this->getCmd(null, 'luxmetre');

            if (!is_object($cmdT)) {
              $cmdT = new fibaroCmd();
			  $cmdT->setName(__('Lumxmetre', __FILE__));
              //$cmdT->setTemplate('dashboard','tile' );
              //$cmdT->setTemplate('mobile', 'tile');
              
            }
			 $cmdT->setLogicalId('luxmetre');
              $cmdT->setEqLogic_id($this->getId());
              $cmdT->setOrder(1);
              $cmdT->setIsVisible(1);
              $cmdT->setValue('Luxmetre');
              $cmdT->setType('info');
			  $cmdT->setSubType('numeric');
              // on defini l'unité
          	  $cmdT->setUnite('Lux');
              $cmdT->save(); 
            
            //Refresh Lumière
            $cmdTR = $this->getCmd(null, 'refresh');
        if (!is_object($cmdTR))//$getDataCmd
        {
            // Création de la commande Rafraichir
            $cmdTR = new fibaroCmd();
            // Nom affiché
            $cmdTR->setName('RafraichirLum');
            // Identifiant de la commande
            $cmdTR->setLogicalId('refresh');
            // Identifiant de l'équipement
            $cmdTR->setEqLogic_id($this->getId());
            // Type de la commande
            $cmdTR->setType('action');
            // Sous-type de la commande
            $cmdTR->setSubType('other');
            // Visibilité de la commande
            $cmdTR->setIsVisible(1);
            // Sauvegarde de la commande
            $cmdTR->save();
        }
            
          break;     
            
         case "com.fibaro.FGRM222": //volets
         case "com.fibaro.FGR223";
            
            //refreshVol
            $cmdVol = $this->getCmd(null, 'refresh');
        if (!is_object($cmdVol))
        {
            // Création de la commande Rafraichir
            $cmdVol = new fibaroCmd();
            // Nom affiché
            $cmdVol->setName('RafraichirVol');
            // Identifiant de la commande
            $cmdVol->setLogicalId('refresh');
            // Identifiant de l'équipement
            $cmdVol->setEqLogic_id($this->getId());
            // Type de la commande
            $cmdVol->setType('action');
            // Sous-type de la commande
            $cmdVol->setSubType('other');
            // Visibilité de la commande
            $cmdVol->setIsVisible(1);
            // Sauvegarde de la commande
            $cmdVol->save();
        }
            
            //open
            $cmdOpen = $this->getCmd(null, 'open');

            if (!is_object($cmdOpen)) {
              $cmdOpen = new fibaroCmd();
			  $cmdOpen->setName(__('Open', __FILE__));
              
            }
			  $cmdOpen->setLogicalId('open');
              $cmdOpen->setEqLogic_id($this->getId());
              $cmdOpen->setOrder(0);
              $cmdOpen->setIsVisible(1);
              $cmdOpen->setValue('Open');
              $cmdOpen->setType('action');
			  $cmdOpen->setSubType('other');
              $cmdOpen->save(); 
            
            //close
            $cmdClose = $this->getCmd(null, 'close');

            if (!is_object($cmdClose)) {
              $cmdClose = new fibaroCmd();
			  $cmdClose->setName(__('Close', __FILE__));
              
            }
			  $cmdClose->setLogicalId('close');
              $cmdClose->setEqLogic_id($this->getId());
              $cmdClose->setOrder(1);
              $cmdClose->setIsVisible(1);
              $cmdClose->setValue('Close');
              $cmdClose->setType('action');
			  $cmdClose->setSubType('other');
              $cmdClose->save(); 
            
            //stop
            $cmdStop = $this->getCmd(null, 'stop');

            if (!is_object($cmdStop)) {
              $cmdStop = new fibaroCmd();
			  $cmdStop->setName(__('Stop', __FILE__));
              
            }
			  $cmdStop->setLogicalId('stop');
              $cmdStop->setEqLogic_id($this->getId());
              $cmdStop->setOrder(2);
              $cmdStop->setIsVisible(1);
              $cmdStop->setValue('Stop');
              $cmdStop->setType('action');
			  $cmdStop->setSubType('other');
              $cmdStop->save(); 
            
            
            //slider
            $cmdSlider = $this->getCmd(null, 'sliderr');

            if (!is_object($cmdSlider)) {
              $cmdSlider = new fibaroCmd();
			  $cmdSlider->setName(__('Slider', __FILE__));
              
            }
			  $cmdSlider->setLogicalId('sliderr');
              $cmdSlider->setEqLogic_id($this->getId());
              $cmdSlider->setOrder(3);
              $cmdSlider->setIsVisible(1);
              $cmdSlider->setType('action');
			  $cmdSlider->setSubType('slider');
              $cmdSlider->save();
            
            //Etat
           	$cmdEtatv = $this->getCmd(null, 'etatv');

            if (!is_object($cmdEtatv)) {
              $cmdEtatv = new fibaroCmd();
			  $cmdEtatv->setName(__('Etat', __FILE__));
              $cmdEtatv->setTemplate('dashboard','shutter' );
              $cmdEtatv->setTemplate('mobile', 'shutter');
            }
			  $cmdEtatv->setLogicalId('etatv');
              $cmdEtatv->setEqLogic_id($this->getId());
              $cmdEtatv->setOrder(4);
              $cmdEtatv->setIsVisible(1);
              $cmdEtatv->setValue('Etatv');
              $cmdEtatv->setType('info');
			  $cmdEtatv->setSubType('numeric');           
              $cmdEtatv->save(); 
            
          break;
            
         case "com.fibaro.multilevelSwitch": //dimmer
         case "com.fibaro.FGD212": 
            
            //refreshDim
            $cmdVol = $this->getCmd(null, 'refresh');
        if (!is_object($cmdVol))
        {
            // Création de la commande Rafraichir
            $cmdVol = new fibaroCmd();
            // Nom affiché
            $cmdVol->setName('RafraichirVol'); //utilise même que les volets
            // Identifiant de la commande
            $cmdVol->setLogicalId('refresh');
            // Identifiant de l'équipement
            $cmdVol->setEqLogic_id($this->getId());
            // Type de la commande
            $cmdVol->setType('action');
            // Sous-type de la commande
            $cmdVol->setSubType('other');
            // Visibilité de la commande
            $cmdVol->setIsVisible(1);
            // Sauvegarde de la commande
            $cmdVol->save();
        }
            
            //On
            $cmdOn = $this->getCmd(null, 'on');

            if (!is_object($cmdOn)) {             
              $cmdOn = new fibaroCmd();
              $cmdOn->setName(__('ON', __FILE__)); 
              
            }
			  $cmdOn->setLogicalId('on');
              $cmdOn->setEqLogic_id($this->getId());
              $cmdOn->setOrder(1);
              $cmdOn->setIsVisible(1);
              $cmdOn->setValue('ON');
              $cmdOn->setType('action');
              $cmdOn->setSubType('other');
              $cmdOn->save();
            
            //Off
            $cmdOff = $this->getCmd(null, 'off');

            if (!is_object($cmdOff)) {             
              $cmdOff = new fibaroCmd();
              $cmdOff->setName(__('OFF', __FILE__)); 
              
            }
			  $cmdOff->setLogicalId('off');
              $cmdOff->setEqLogic_id($this->getId());
              $cmdOff->setOrder(2);
              $cmdOff->setIsVisible(1);
              $cmdOff->setValue('OFF');
              $cmdOff->setType('action');
              $cmdOff->setSubType('other');
              $cmdOff->save();
            
            
            //slider
            $cmdSlider = $this->getCmd(null, 'sliderr');

            if (!is_object($cmdSlider)) {
              $cmdSlider = new fibaroCmd();
			  $cmdSlider->setName(__('Slider', __FILE__));
              
            }
			  $cmdSlider->setLogicalId('sliderr');
              $cmdSlider->setEqLogic_id($this->getId());
              $cmdSlider->setOrder(3);
              $cmdSlider->setIsVisible(1);
              $cmdSlider->setType('action');
			  $cmdSlider->setSubType('slider');
              $cmdSlider->save();
            
            //Etat
           	$cmdEtatv = $this->getCmd(null, 'etatv');

            if (!is_object($cmdEtatv)) {
              $cmdEtatv = new fibaroCmd();
			  $cmdEtatv->setName(__('Etat', __FILE__));
              //$cmdEtatv->setTemplate('dashboard','light' );
              //$cmdEtatv->setTemplate('mobile', 'light');
            }
			  $cmdEtatv->setLogicalId('etatv');
              $cmdEtatv->setEqLogic_id($this->getId());
              $cmdEtatv->setOrder(4);
              $cmdEtatv->setIsVisible(1);
              $cmdEtatv->setValue('Etatv');
              $cmdEtatv->setType('info');
			  $cmdEtatv->setSubType('numeric');           
              $cmdEtatv->save(); 
            
         break;
            
         case "com.fibaro.doorSensor": //detecteur ouverture
         case "com.fibaro.windowSensor": //detecteur ouverture
         case "com.fibaro.FGMS001": //detecteur de mouvment
         case "com.fibaro.FGMS001v2": //detecteur de mouvment v2
         case "com.fibaro.motionSensor": //detecteur de mouvment 
         case "com.fibaro.satelZone": //detecteur de mouvment capteurs d'alarme Satel
                       
            //Refresh
            $getDataCmd = $this->getCmd(null, 'refresh');
        if (!is_object($getDataCmd))
        {
            // Création de la commande Rafraichir
            $cmd = new fibaroCmd();
            // Nom affiché
            $cmd->setName('RafraichirOuverture');
            // Identifiant de la commande
            $cmd->setLogicalId('refresh');
            // Identifiant de l'équipement
            $cmd->setEqLogic_id($this->getId());
            // Type de la commande
            $cmd->setType('action');
            // Sous-type de la commande
            $cmd->setSubType('other');
            // Visibilité de la commande
            $cmd->setIsVisible(1);
            // Sauvegarde de la commande
            $cmd->save();
        }
            
            //Capteur ouverture
           	$cmdOuv = $this->getCmd(null, 'ouverture');

            if (!is_object($cmdOuv)) {
              $cmdOuv = new fibaroCmd();
			  $cmdOuv->setName(__('Ouverture', __FILE__));
              //$cmdOuv->setTemplate('dashboard','door' );
              //$cmdOuv->setTemplate('mobile', 'door');
            }
			  $cmdOuv->setLogicalId('ouverture');
              $cmdOuv->setEqLogic_id($this->getId());
              $cmdOuv->setOrder(0);
              $cmdOuv->setIsVisible(1);
              $cmdOuv->setValue('ouverture');
              $cmdOuv->setType('info');
			  $cmdOuv->setSubType('binary');            
              $cmdOuv->save();
            
            //Armemnt
           	$cmdArm = $this->getCmd(null, 'armed');

            if (!is_object($cmdArm)) {
              $cmdArm = new fibaroCmd();
			  $cmdArm->setName(__('Armed', __FILE__));
              //$cmdArm->setTemplate('dashboard','presence' );
              //$cmdArm->setTemplate('mobile', 'presence');
            }
			  $cmdArm->setLogicalId('armed');
              $cmdArm->setEqLogic_id($this->getId());
              $cmdArm->setOrder(0);
              $cmdArm->setIsVisible(1);
              $cmdArm->setValue('armed');
              $cmdArm->setType('info');
			  $cmdArm->setSubType('binary');            
              $cmdArm->save();
            
         break;
                
                
         case "com.fibaro.FGSS001": // Ajout de Détecteur de Fumé (FGSS001)
         case "com.fibaro.FGFS101": // Ajout de Détecteur d'inodations (FGFS101)
         case "com.fibaro.FGCD001": // Ajout de Détecteur de CO2 (FGCD001)
                

                       
            //Refresh
            $getDataCmd = $this->getCmd(null, 'refresh');
        if (!is_object($getDataCmd))
        {
            // Création de la commande Rafraichir
            $cmd = new fibaroCmd();
            // Nom affiché
            $cmd->setName('RafraichirOuverture');
            // Identifiant de la commande
            $cmd->setLogicalId('refresh');
            // Identifiant de l'équipement
            $cmd->setEqLogic_id($this->getId());
            // Type de la commande
            $cmd->setType('action');
            // Sous-type de la commande
            $cmd->setSubType('other');
            // Visibilité de la commande
            $cmd->setIsVisible(1);
            // Sauvegarde de la commande
            $cmd->save();
        }
            
            //Capteur ouverture
           	$cmdOuv = $this->getCmd(null, 'ouverture');

            if (!is_object($cmdOuv)) {
              $cmdOuv = new fibaroCmd();
			  $cmdOuv->setName(__('Alarme', __FILE__));
              //$cmdOuv->setTemplate('dashboard','door' );
              //$cmdOuv->setTemplate('mobile', 'door');
            }
			  $cmdOuv->setLogicalId('ouverture');
              $cmdOuv->setEqLogic_id($this->getId());
              $cmdOuv->setOrder(0);
              $cmdOuv->setIsVisible(1);
              $cmdOuv->setValue('ouverture');
              $cmdOuv->setType('info');
			  $cmdOuv->setSubType('binary');            
              $cmdOuv->save();
                
        break;
                
            
         //case "com.fibaro.multilevelSwitch": //dimmer
           
            
         //break;
    	}
      
      

    }

    public function preUpdate() {
        
    }

    public function postUpdate() {   
   
    }

    public function preRemove() {
        
    }

    public function postRemove() {
        
    }

    /*
     * Non obligatoire mais permet de modifier l'affichage du widget si vous en avez besoin
      public function toHtml($_version = 'dashboard') {

      }
     */

    /*
     * Non obligatoire mais ca permet de déclencher une action après modification de variable de configuration
    public static function postConfig_<Variable>() {
    }
     */

    /*
     * Non obligatoire mais ca permet de déclencher une action avant modification de variable de configuration
    public static function preConfig_<Variable>() {
    }
     */

    /*     * **********************Getteur Setteur*************************** */
}

class fibaroCmd extends cmd {
    /*     * *************************Attributs****************************** */


    /*     * ***********************Methode static*************************** */


    /*     * *********************Methode d'instance************************* */

    /*
     * Non obligatoire permet de demander de ne pas supprimer les commandes même si elles ne sont pas dans la nouvelle configuration de l'équipement envoyé en JS
      public function dontRemoveCmd() {
      return true;
      }
     */
  

    public function execute($_options = array()) {
      
      
      	//recuperation de IP, Login, Mdp  (parametre Global de module)
      	$fibaroIP = config::byKey('fibaroIP', 'fibaro', 'none');
      	$fibaroLogin = config::byKey('fibaroLogin', 'fibaro', 'none');
      	$fibaroLogin = urlencode($fibaroLogin);
      	$fibaroMDP = config::byKey('fibaroMDP', 'fibaro', 'none');
        $fibaroMDP = urlencode($fibaroMDP);
      
   		$eqLogic = $this->getEqLogic();
      	$idModule = $eqLogic->getConfiguration('fibaroIdModule');
      
      	 //recuperation de json de module
      $json_source = file_get_contents("http://$fibaroLogin:$fibaroMDP@$fibaroIP/api/devices?id=$idModule"); 
      //traitement de json
      $json_data = json_decode($json_source);
      //exploitation des variables json
      $Type = $json_data->type;
      
      $Nom = $json_data->name;
      if(!isset($json_data->{'properties'}->{'value'})) {$Etatt =''; } else {$Etatt = $json_data->{'properties'}->{'value'};}
      if(!isset($json_data->{'properties'}->{'power'})) {$Power =''; } else {$Power = $json_data->{'properties'}->{'power'};}
      if(!isset($json_data->{'properties'}->{'armed'})) {$Armed =''; } else {$Armed = $json_data->{'properties'}->{'armed'};}
      
      
      // Test pour ne répondre qu'à la commande rafraichir
    if (($this->getLogicalId() == 'refresh')){
      
      	

        // On récupère l'équipement à partir de l'identifiant fournit par la commande
        $fibaroObj = fibaro::byId($this->getEqlogic_id());
      	//log::add('fibaro', 'debug', 'Nom:'.$this->getName());
      
      
       //si activer par cmd des ON/Off
      if ($this->getName() == 'Rafraichir'){
        // On récupère l'équipement à partir de l'identifiant fournit par la commande
        //$fibaroObj = fibaro::byId($this->getEqlogic_id());
        $cmdEtat = $fibaroObj->getCmd('info', 'etat');
        // On lui ajoute un évènement avec pour information '$Etatt'
        $cmdEtat->event($Etatt);
        // On sauvegarde cet évènement
        $cmdEtat->save();
      	//log::add('fibaro', 'debug', 'etat:'.$Etatt);
        
       }
      
      //si activer par cmd des Temperatures
      if ($this->getName() == 'RafraichirTmp'){
        // On récupère l'équipement à partir de l'identifiant fournit par la commande
        //$fibaroObj = fibaro::byId($this->getEqlogic_id());
        $cmdEtatT = $fibaroObj->getCmd('info', 'temperature');
        // On lui ajoute un évènement avec pour information '$Etatt'
        $cmdEtatT->event($Etatt);
        // On sauvegarde cet évènement
        $cmdEtatT->save();
      	//log::add('fibaro', 'debug', 'temperature:'.$Etatt);
       }
      
      //si activer par cmd des Humidité
      if ($this->getName() == 'RafraichirHum'){
        // On récupère l'équipement à partir de l'identifiant fournit par la commande
        //$fibaroObj = fibaro::byId($this->getEqlogic_id());
        $cmdEtatT = $fibaroObj->getCmd('info', 'humidite');
        // On lui ajoute un évènement avec pour information '$Etatt'
        $cmdEtatT->event($Etatt);
        // On sauvegarde cet évènement
        $cmdEtatT->save();
      	//log::add('fibaro', 'debug', 'temperature:'.$Etatt);
       }
      
      //si activer par cmd des Lumière
      if ($this->getName() == 'RafraichirLum'){
        // On récupère l'équipement à partir de l'identifiant fournit par la commande
        //$fibaroObj = fibaro::byId($this->getEqlogic_id());
        $cmdEtatT = $fibaroObj->getCmd('info', 'luxmetre');
        // On lui ajoute un évènement avec pour information '$Etatt'
        $cmdEtatT->event($Etatt);
        // On sauvegarde cet évènement
        $cmdEtatT->save();
      	//log::add('fibaro', 'debug', 'temperature:'.$Etatt);
       }
      
      //si activer par cmd des Volets
      if ($this->getName() == 'RafraichirVol'){
        // On récupère l'équipement à partir de l'identifiant fournit par la commande
        //$fibaroObj = fibaro::byId($this->getEqlogic_id());
        $cmdEtatV = $fibaroObj->getCmd('info', 'etatv');
        // On lui ajoute un évènement avec pour information '$Etatt'
        $cmdEtatV->event($Etatt);
        // On sauvegarde cet évènement
        $cmdEtatV->save();
      	//log::add('fibaro', 'debug', 'Value Slider:'.$Etatt);
       }
      
       //si activer par detecteur ouverture
      if ($this->getName() == 'RafraichirOuverture'){
        // On récupère l'équipement à partir de l'identifiant fournit par la commande
        //$fibaroObj = fibaro::byId($this->getEqlogic_id());
        $cmdEtatOuv = $fibaroObj->getCmd('info', 'ouverture');
        $cmdEtatArm = $fibaroObj->getCmd('info', 'armed');        
        // On lui ajoute un évènement avec pour information '$Etatt'
        if($Etatt == 'false') {$Etatt = 'true';} else {$Etatt = 'false';} //on inverse l'etat pour template
        if($Armed == 'false') {$Armed = 'true';} else {$Armed = 'false';} //on inverse l'etat pour template
        $cmdEtatOuv->event($Etatt);
        $cmdEtatArm->event($Armed);        
        // On sauvegarde cet évènement
        $cmdEtatOuv->save();
        $cmdEtatArm->save();
      	//log::add('fibaro', 'debug', 'Value Ouvert:'.$Etatt);
        //log::add('fibaro', 'debug', 'Value Armed:'.$Armed);
       }
  
    }

    
            
      // Test pour ne répondre qu'à la commande ON
    if ($this->getLogicalId() == 'on')
    {

        //on execute API Fibaro
      	$url="http://$fibaroLogin:$fibaroMDP@$fibaroIP/api/callAction?deviceID=$idModule&name=turnOn";
      	$url = new com_http($url);
     	$response = $url->exec(5, 1);
		//log::add('fibaro', 'debug', 'response:'.$this->getLogicalId());
      	
      	//on change l'etat à 1
      	// On récupère l'équipement à partir de l'identifiant fournit par la commande
        //$fibaroObj = fibaro::byId($this->getEqlogic_id());
        // On récupère la commande 'etat' appartenant à l'équipement
        //$cmdEtat = $fibaroObj->getCmd('info', 'etat');
        // On lui ajoute un évènement avec pour information '$Etatt'
        //$cmdEtat->event(1);
        // On sauvegarde cet évènement
        //$cmdEtat->save();   	

    }
        
      
      // Test pour ne répondre qu'à la commande OFF
    if ($this->getLogicalId() == 'off')
    {
        //on execute API Fibaro 
      	$url="http://$fibaroLogin:$fibaroMDP@$fibaroIP/api/callAction?deviceID=$idModule&name=turnOff";
      	$url = new com_http($url);
     	$response = $url->exec(5, 1);
      	//log::add('fibaro', 'debug', 'response:'.$this->getLogicalId());
    }
     
     // Test pour ne répondre qu'à la commande Open
    if ($this->getLogicalId() == 'open')
    {
        //on execute API Fibaro
      	$url="http://$fibaroLogin:$fibaroMDP@$fibaroIP/api/callAction?deviceID=$idModule&name=setValue&arg1=100";
      	$url = new com_http($url);
     	$response = $url->exec(5, 1);
      	//log::add('fibaro', 'debug', 'response:'.$this->getLogicalId());
    }
    
      // Test pour ne répondre qu'à la commande Close 
    if ($this->getLogicalId() == 'close')
    {
        //on execute API Fibaro
      	$url="http://$fibaroLogin:$fibaroMDP@$fibaroIP/api/callAction?deviceID=$idModule&name=setValue&arg1=0";
      	$url = new com_http($url);
     	$response = $url->exec(5, 1);
      	//log::add('fibaro', 'debug', 'response:'.$this->getLogicalId());
    }
    
      // Test pour ne répondre qu'à la commande Stop 
    if ($this->getLogicalId() == 'stop')
    {
        //on execute API Fibaro
      	$url="http://$fibaroLogin:$fibaroMDP@$fibaroIP/api/callAction?deviceID=$idModule&name=stop";
      	$url = new com_http($url);
     	$response = $url->exec(5, 1);
      	//log::add('fibaro', 'debug', 'response:'.$this->getLogicalId());
    }
     
      // Test pour ne répondre qu'à la commande Slider 
    if ($this->getLogicalId() == 'sliderr')
    {
        //on execute API Fibaro
      	$var = $_options['slider'];
      	$url = "http://$fibaroLogin:$fibaroMDP@$fibaroIP/api/callAction?deviceID=$idModule&name=setValue&arg1=$var";
      	$url = new com_http($url);
     	$response = $url->exec(5, 1);
      	//log::add('fibaro', 'debug', 'response:'.$this->getLogicalId());
      	//log::add('fibaro', 'debug', 'slider Value:'.$_options['slider']);
    }
      
    }

    /*     * **********************Getteur Setteur*************************** */

  }
