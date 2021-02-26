[![Build Status](https://www.travis-ci.com/ChrisCrawford1/vatflights.svg?branch=develop)](https://www.travis-ci.com/ChrisCrawford1/vatflights)
[![codecov](https://codecov.io/gh/ChrisCrawford1/vatflights/branch/master/graph/badge.svg?token=IC72P1FMQU)](https://codecov.io/gh/ChrisCrawford1/vatflights)
<h3 align="center">VatFlights</h3>
  <p align="center">
    A place to view data about flights on the Vatsim network
    <br />
  </p>


<!-- TABLE OF CONTENTS -->
<details open="open">
  <summary>Table of Contents</summary>
  <ol>
    <li>
      <a href="#about-the-project">About The Project</a>
      <ul>
        <li><a href="#built-with">Built With</a></li>
      </ul>
    </li>
    <li><a href="#contributing">Contributing</a></li>
    <li><a href="#license">License</a></li>
    <li><a href="#contact">Contact</a></li>
    <li><a href="#acknowledgements">Acknowledgements</a></li>
  </ol>
</details>

<!-- ABOUT THE PROJECT -->
## About The Project

This came about from my own general curiosity and seeing that Vatsim offered a fairly regularly updated json file
that I could poll every five minutes or so to see the latest data on the network. 

I wanted to know some general stats about the network on a day-to-day basis, hence this project came about.

Rather than make a CLI tool which I would usually do I decided to make it more accessible to others if they ever had the interest in the same kind of thing.

### Built With
* [Laravel](https://laravel.com)
* [TailwindCSS](https://tailwindcss.com)

<!-- CONTRIBUTING -->
## Contributing

Contributions are what make the open source community such an amazing place to be learn, inspire, and create. Any contributions you make are **greatly appreciated**.

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/MyFeature`)
3. Commit your Changes (`git commit -m 'Adding a new feature'`)
4. Push to the Branch (`git push origin feature/MyFeature`)
5. Open a Pull Request


**Please ensure that any complex logic changes / additions are explained and accompanied by respective tests.**

<!-- LICENSE -->
## License

Distributed under the MIT License. See `LICENSE` for more information.

<!-- CONTACT -->
## Contact

Christopher Crawford - [@ScopherTk](https://twitter.com/ScopherTk) - contact@crawforddev.com

<!-- ACKNOWLEDGEMENTS -->
## Acknowledgements
* [OpenFlights](https://github.com/jpatokal/openflights)

The data used for the airline matching came from the awesome people at OpenFlights. 
I did do some manual collation of other airlines seen on the network and not on the spreadsheet they provide, 
other work such as removing very old airlines was done as well.
