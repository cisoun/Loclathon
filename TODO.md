# TO DO

## Milestone 1 - 2021-03-02
- [X] [CRITICAL] Prevent shop confirmation to send order once again when refreshing the page (/shop/confirm).
- [X] Fix language selection in nav menu on mobiles.
- [X] Add support for Paypal.
  - [ ] [CANCELLED] ~~Handle PayPal exceptions: page showing error to customer ("Sorry, got <error>, admin was notified.").~~
- [X] Add 2021 date in homepage logo.

## Milestone 2 - 2021-04
- [ ] [CRITICAL] Handle lack of bottles stock in shop.
- [ ] [CRITICAL] Add support for TWINT.
- [ ] Shop: add JS spinner when the PayPal order is being created.
- [ ] Add german translations.
- [ ] Photos carousel in homepage.
- [ ] Add GDPR clause / privacy policy.
  - Customers must know that their session data are cached during the order
    process.

## Milestone 3 - TBD
- Improve shop.
  - Must support more articles.
  - Extract and isolate shop into a subdomain (shop.loclathon.ch).
- Improve photos preview (use JS to allow photos navigation in albums).

## Ideas
- Use SQLite 3.35 to use the new `RETURNING` clause.
- Change layout of the confirmation mail.
  - Put all contact informations at the left bottom.
  - Put transaction informations at the right bottom.
