# Plugin Fibaro pour Jeedom


![fibaro_icon](https://github.com/rems02/fibaro/raw/master/docs/fr_FR/fibaro_icon.png)

Description 
===

Ce plugin très puissant et très complet vous permettra de gérer 
et interagir avec les modules de vos boxes Fibaro HC2 ou HCL.
Le type de modules est détecté automatiquement puis inséré dans Jeedom.
Les deux boxes communiques facilement et le changement d'état est presque instantané
grace au script LUA pour la HC2 ou un scenario pour la HCL.
L'ajout de modules est régulier, leurs intégration peut être ajoutée sur une simple demande.


_Modules compatible:_
- interrupteur On/Off (état / on / off)
- Wall Plug Fibaro (état / on / off)
- Wall Plug NodOn (état / on / off)
- Capteurs de températures (état)
- Volet roulant  (état / Open / close / stop / slider)
- Variateurs / dimmers (état / On / Off / slider)
- Détecteurs d'ouvertures (état ouverture  / état armement)
- Détecteurs de mouvements (état mouvement  / état armement)
- Détecteurs de mouvements SATEL (état mouvement / état armement)
- Détecteurs de mouvements l'œil de Sauron v2 (état mouvement / état armement)
- Détecteurs d'humidité (état)
- Luxmètres (état)

Configuration
===

Dans la partie _Configuration_ Renseignez l'IP, login et mot de passe de votre box (HC2 ou HCL)

![ip_login_password](https://github.com/rems02/fibaro/raw/master/docs/fr_FR/ip_login_password.PNG)

Cliquez sur bouton **Ajouter**

![add_devices](https://github.com/rems02/fibaro/raw/master/docs/fr_FR/add_devices.PNG)

Renseignez bien **ID** de votre module que vous souhaitez d'ajouter

![ID_Device](https://github.com/rems02/fibaro/raw/master/docs/fr_FR/ID_Device.PNG)

Retour d'information Fibaro->Jeedom
===

HC2
---

Pour Rafraîchir des modules et leurs passer l'information de changement d'état il faut creer une scene dans votre HC2

**_Code LUA_**

    --[[
    %% properties
    221 value ---- Id des modules Fibaro
    197 value ---- --//--
    218 value
    665 value
    246 value
    705 value
    705 armed ---- Pour détecteur ouverture ou mouvement seulement !!!
    %% events
    %% globals
    --]]

    local deviceID = {2004,2005,2062,2058,2094,2114}; -- ID de la commande Rafraichir de chaque module Jeedom
    local apiKeyJeedom = "gr5GfLIHd25f0325dsdeGFTRfFf5s58empsPjHyGfGFFSGF"; -- API de votre Jeedom
    local IP_Jeedom = "192.168.X.X"; -- IP de votre Jeedom
    
    for i=1, #deviceID do

    local http = net.HTTPClient()
    local url = "http://" ..IP_Jeedom.. "/core/api/jeeApi.php?apikey=" ..apiKeyJeedom .."&type=cmd&id=" ..deviceID[i]  
    http:request(url, {
	    success = function(response)
		    if response.status == 200 then
			    fibaro:debug('OK, réponse : '.. response.data)
		    else
			    fibaro:debug("Erreur : status=" .. tostring(response.status))
		    end
	    end,
	    error = function(err)
		    fibaro:debug("Erreur : " .. err)
	    end,
	    options = {
		    method = 'GET'
	    }
    })  
    i=i+1;
    end


HCL
---
Voilà la procédure de création d'un scénario dans votre Jeedom

Dans Outil scénario:.

![Ajouter](https://github.com/rems02/fibaro/raw/master/docs/fr_FR/1.PNG)

![Nom](https://github.com/rems02/fibaro/raw/master/docs/fr_FR/2.PNG)

Sélectionner **Programmé** puis **+** puis ajouter * * * * **

![déclencheur](https://github.com/rems02/fibaro/raw/master/docs/fr_FR/3.PNG)

![scenario](https://github.com/rems02/fibaro/raw/master/docs/fr_FR/4.PNG)

![ajouter bloc](https://github.com/rems02/fibaro/raw/master/docs/fr_FR/5.PNG)

![action](https://github.com/rems02/fibaro/raw/master/docs/fr_FR/6.PNG)

![ajouter](https://github.com/rems02/fibaro/raw/master/docs/fr_FR/7.PNG)

a partir d'ici vous pouvez répéter la procédure tant de fois que vous avez de modules a importer

![action](https://github.com/rems02/fibaro/raw/master/docs/fr_FR/8.PNG)

![valider](https://github.com/rems02/fibaro/raw/master/docs/fr_FR/9.PNG)

Changelog
===
[Le Changelog se trouve ici](https://rems02.github.io/fibaro/fr_FR/changelog)
