# Получение тестового сертификата

> Это черновик!
 
Вся команда выглядит вот так:
```shell
/opt/cprocsp/bin/amd64/cryptcp \
    -creatrqst \
    -rdn "CN=Название сертификата, E=info@site.domain, OID.1.2.643.100.4=000000000000, OID.1.2.643.100.1=00000000000000, OID.1.2.643.3.131.1.1=000000000000, OID.1.2.643.100.3=00000000000, O=\"ООО \"МОЯ КОМПАНИЯ\"\", T=Моя должность, SN=Фамиля, G=Имя Отчество, C=RU, L=Г. МОСКВА" \
    -certusage "1.3.6.1.5.5.7.3.4,1.3.6.1.5.5.7.3.2,1.2.643.2.2.34.6" \
    -ku -cont '\\.\HDIMAGE\ContainerName' \
    -provtype 80 ./main.req
```