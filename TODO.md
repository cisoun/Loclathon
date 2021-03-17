# TO DO

## Milestone 1 - End of March 2021
- [X] [CRITICAL] Prevent shop confirmation to send order once again when refreshing the page (/shop/confirm).
- [ ] [BUG] Fix language selection in nav menu on mobiles.
- [X] Add support for Paypal.
  - [ ] Handle PayPal exceptions: page showing error to customer ("Sorry, got <error>, admin was notified.").

## Milestone 2 - April 2021
- [ ] Shop: add JS spinner when the PayPal order is being created.
- [ ] Add german translations.
- [ ] Photos carousel in homepage.
- [ ] Add support for TWINT.
- [ ] Add GDPR clause / privacy policy.
  - Shop customers must know that their session data are cached during the order process.

## Milestone 3
- Extract shop from website to a new subdomain/subfolder.
  - Let's create a customizable shop.
- Improve shop to handle more articles.
- Improve photos preview (use JS to allow photos navigation in albums).

## Ideas
- Use SQLite 3.35 to use the new `RETURNING` clause.
- Change layout of the confirmation mail.
  - Put all contact informations at the left bottom.
  - Put transaction informations at the right bottom.
