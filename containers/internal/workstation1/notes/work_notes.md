# Notes de Travail - Developer Workstation

## Accès Control Station

J'ai enfin reçu les accès pour me connecter à la Control Station !

**IP**: 172.23.0.20
**User**: ctrlops  
**Password**: Ctr10ps@2024!

La clé SSH est dans mon répertoire .ssh/control_station_rsa

## À faire cette semaine

- [ ] Tester le nouveau module de télémétrie
- [ ] Vérifier les logs du satellite ARGOS-7B
- [ ] Mettre à jour la documentation Ada
- [ ] Backup de la base de données télémétrie

## Rappels sécurité

- Ne JAMAIS commiter les credentials dans Git
- La Control Station ne doit être accessible que depuis ma workstation
- Les codes sources Ada sont sensibles - classification TOP SECRET

## Commandes utiles

Se connecter à la Control Station:
```bash
ssh -i ~/.ssh/control_station_rsa ctrlops@172.23.0.20
```

Monter le partage Samba:
```bash
smbclient //file-server/satellite_docs -U developer
# Password: D3v2024!Secure
```

## Contact

En cas de problème, contacter Marcus Chen (Lead Engineer)
