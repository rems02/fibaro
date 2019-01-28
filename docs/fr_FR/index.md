![fibaro_icon](fibaro_icon.png)

Description 
===

Plugin Fibaro récupère et interagie avec les modules de vos box HC2 ou HCL. 
Le type de module est détecté automatiquement puis inséré dans Jeedom.
Modules compatible:
- interrupteur On/Off (état / on / off)
- Capteurs de températures (état)
- Volet roulant  (état / Open / close / stop / slider)

Configuration
===

Renseignez l'IP / login et mot de passe de votre box (HC2 ou HCL)

![ip_login_password](ip_login_password.PNG)

Cliquez sur bouton **Ajouter**

![add_devices](add_devices.PNG)

Renseignez bien **ID** de votre module que vous souhaitez d'ajouter

![ID_Device](ID_Device.PNG)

Retour d'information Fibaro->Jeedom
===

Pour Rafraîchir des modules et leurs passer l'information de changement d'état il faut creer une scene dans votre HC2

  code
  code
  code
