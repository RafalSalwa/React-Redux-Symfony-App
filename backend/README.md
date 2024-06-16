# Symfony API
---

Simple api based on PHP 8.2, Symfony 5, MySQL.

Planning decisions:
- Stable maintained php version -> 8.2
- JWT Token - lexik/jwt-authentication-bundle because has best support for symfony and is build on top of lcobucci/JWT (personal fav) and firewall management with userproviders integration makes them really easy to use
- Symfony mailer - with prepared and integrated into symfony dev env profiler mailer and docker container with mailpit
- Security bundle with stateless firewalls, separate firewall for login and JWT Bearer headers url based


 Some thoughts on security design:
- Registration is custom since we rely on some custom rules,
- Validation, central place is in Entity via assert attributes
- Login - based completly on FormAuthenticator and UserProviderInterface flow since those features are proven to be robust, very reliable with extras like rate limiting
- AWS PHP SDK symfony bundle, as it provides much easier implementation of services since we can use autowiring approach and inject specific clients easier
- File uploaderInterface that is implemented by SimpleUploader and AWSS3Uploader that thanks to DI and autowiring can be injected via `iterable` constructor promotion and we can disable them or add new uploader with only that interface and tag

## ⚙️ Installation
```bash
make up
```
visit 0.0.0.0:8001 or use Postman collection from [docs/](docs/)
