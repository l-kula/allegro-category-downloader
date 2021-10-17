#Skrypt do pobieranie listy kategorii z serwisu allegro.

## Wymagania
* PHP 7.4
* pakiet PHP 7.4 xml (apt install php7.4-xml, dla systemu ubuntu)

## Uruchomienie
Przed uruchomieniem należy zaktualizować ścieżkę, w której znajduje się katalog ze skryptem. W tym celu zmieniamy wartość
`$directoryResult` w pliku `./index/php`.
## Opis
### Autoryzacja
Skrypt wykorzystuje api allegro do pobrania listy wszystkich kategorii. W tym celu zaimplementowany został mechanizm
autoryzacji użytkownika w serwisie allegro. Dokładny opis jak autoryzacja powinna przebiegać, znajduje się
[tutaj](https://developer.allegro.pl/auth/#client-credentials-flow). Skrypt został zarejestrowany na użytkowniku: 
`i-outl_2bi_today`. Wygenerowane klucze, potrzebne do zalogowania znajdują się w pliku
```injectablephp
\Lkula\AllegroCategories\Authorization\AuthorizationManager::CLIENT_ID
\Lkula\AllegroCategories\Authorization\AuthorizationManager::CLIENT_SECRET
```
Gdyby zaszła potrzeba zmiany użytkownika, należy zaktualizować te stałe.

### Pobieranie kategorii
Pobieranie kategorii odbywa się poprzez strzał na odpowiednią ścieżkę api.allegro. Następnie odebrane dane są
konwertowane do pliku xml. Plik ten znajduje się w katalogu `results`.

### Pobieranie zmian kategorii
Skrypt dostarcza też dodatkową funkcjonalność w postaci mechanizmu pobierania zmian kategorii. Opis wykorzystywanej
ścieżki api znajduje się [tutaj](https://developer.allegro.pl/documentation/#operation/getCategoryEventsUsingGET_1).
W pliku `./var/last_change.txt` przechowywany jest identyfikator ostatniej zmiany kategorii. Jest on potrzebny do
odfiltrowania zmian kategorii, które były już odczytane w poprzednim uruchomieniu skrytu. Plik wynikowy znajduje się w 
katalogu `./results`

### Czas wykonania skryptu
Reguła crona znajduje się w pliku `./cron.txt`. Na etapie tworzenia skryptu została utworzona tak, aby uruchamiać go
codziennie o godzinie 3:00. Skrypt na dzień 17.10.2021 wykonuje się ok 2 min.