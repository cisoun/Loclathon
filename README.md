# Loclathon

Source repository for the [Loclathon's website](https://loclathon.ch).

## Summary

*Le Loclathon* is an annual event organized by the *Association du Loclathon*
(which I'm part of) that brings absinthe lovers to a long walk across
the city of Le Locle (NE, Switzerland) for 12 hours. The goal is to enjoy a good
time with friends and discover the beautiful parts of the town by visiting each
of its fountains. There, we drink a glass of absinthe (or anything else) with
the fresh water they deliver.

This website is used to present the event and to sell the dedicated absinthe of
*Le Loclathon*, [La Locloise](https://loclathon.ch/#locloise).

## Requirements

- php >= 7

## Status

List draft of all planned features. *  

**Backend**

 - [X] Custom routing.
 - [X] Custom template engine.
 - [ ] Custom translation manager.
 - [X] Custom cache system.
    - *Used to render and store static pages.*

**Frontend**

 - [X] Custom CSS layout.

**Content**

 - [X] *Loclathon* page.
 - [X] *Locloise* page (to extract from *Loclathon*).
    - [X] Redirect [locloise.ch](locloise.ch) on it.
 - [ ] Custom shop (to be developed separately).
 - [X] Contact page.
 - [X] Photos page with subpages for each year.

**QA**

 - [ ] Good accessibility.
 - [ ] Low time response.
 - [ ] Minimal dependencies.
    - *Use pure CSS and vanilla JS.*
    - *Use the fewest external packages (except customs).*
 - [ ] Support for french, english and german.

<sub>\* A checked feature does not mean that it is finished but exists.</sub>
