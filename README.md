[![Build Status](https://travis-ci.org/dmecke/OpenSoccerStar.svg)](https://travis-ci.org/dmecke/OpenSoccerStar)

## Introduction
This is an experiment. Is it possible to create a browsergame by the open source community?

## Background
In 2002 I started coding my first own browsergame Onlinetennis.net. It was then released in 2004 and just had it's 10th anniversary. With my coding skills the code quality improved. But coding alone is a hard challenge. There are issues in all parts - frontend, backend, server maintenance, community management, marketing, tools, etc.

## Description
I always had another game in my mind - a soccer manager game in which you are not the manager or trainer, but the player. You receive contract offers and choose a team to play for. The training plan is set up by your coach, but you can decide which parts of the training you want to spend the most energy in. Or even save your energy for giving interviews, driving fast cars or party all night. This way you won't become the perfect player, but the press will make you popular anyway.
Interaction with other real players enable you to improve team play - or get the unwanted trainer out of the team.

That's a huge project. So I eventually decided to open up the development and try to find others to join it. As in every project there is much more to do than just coding. There is game design, art, translation, testing or simply playing the game.

## Philosophy
So far there is only the skeleton of the project, a plain Symfony2 project. I used Symfony2 for all my last projects so I decided to stick to it as I think it fits the requirements. I also coded some parts of the game in a private repository and am planning to move it here step by step. Not all at once as I want to clean it up at the same time.
Important in my opinion is to use as many existing libraries as possible to keep the actual business logic small and maintainable. Things like Symfony2, jQuery and a frontend framework might be obvious here. But I think it will also help to not include game mechanics that are very abstract as for example a league management. It might be not existing yet, but moving this into it's own repository enables others to use and extend it without the need to join this specific project. A league management that is able to create tables and fixtures, manage relegation and promotion, could be also used for the private Fifa tournaments for example.

When reading about how to start an open source project, there is always the advice to not start and hope for help before a base is made that offers a real use case for the people. I decided for the opposite and start with this simple text. It's not that I hope for many people to read this document or even join the project. But starting the project in the public right from the beginning takes away the pain to think about when the best time is to release a first version.

## Getting Started
So if you like the idea, simply watch this project to get informed about any updates. And when you feel the time is right, just open an issue with a question or suggestion.

## Next Steps
The next steps will be to change the project skeleton into a very very simple, but playable game, the minimum viable product. Furthermore I would like to outline my vision of the project a bit more, so everybody is able to see in what direction the project shall go.

Thanks for reading this text and thanks for watching this repository!
