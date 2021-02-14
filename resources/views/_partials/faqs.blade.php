<section class="text-stone-500">
    <div class="container px-5 py-12 mx-auto">
        <div class="text-center mb-10">
            <h1 class="sm:text-3xl text-2xl font-medium text-center title-font text-gray-900 mb-4">
                Frequently Asked Questions
            </h1>
            <p class="text-base leading-relaxed xl:w-2/4 lg:w-3/4 mx-auto">
                Answers to questions about the application, what it does and how it does it.
            </p>
        </div>
        <div class="flex flex-wrap lg:w-4/5 sm:mx-auto sm:mb-2 -mx-2">
            <div class="w-full lg:w-1/2 px-4 py-2">
                @component('components.faq')
                    @slot('title')
                        Where does the data come from?
                    @endslot
                    @slot('body')
                        <p class="ml-1 mr-2 pt-2">
                            Vatsim very generously provide a public json file with basically a snapshot of what is going on, on the network at that given time.
                            A list of these files can be found <a class="hover:underline text-blue-500" href="https://status.vatsim.net/" title="Go to the Vatsim data pages.">here.</a>
                        </p>
                    @endslot
                @endcomponent
                @component('components.faq')
                    @slot('title')
                        How often does the data refresh?
                    @endslot
                    @slot('body')
                        <p class="ml-1 mr-2 pt-2">
                            As part of the data file that Vatsim provide, there is some metadata in there which contains an updated at timestamp and a reload, which tells us
                            when it will next be rehydrated. VatFlights polls that data every five minutes to get updates.
                        </p>
                    @endslot
                @endcomponent
                @component('components.faq')
                    @slot('title')
                        Is the project open source?
                    @endslot
                    @slot('body')
                        <p class="ml-1 mr-2 pt-2">
                            Yes! The entire codebase for VatFlights is available to be read through at your leisure, you can either use the GitHub icon on the navbar or
                            alternatively click <a class="hover:underline text-blue-500" href="https://github.com/ChrisCrawford1/vatflights" title="Go to the GitHub source.">here.</a>
                        </p>
                    @endslot
                @endcomponent
            </div>
            <div class="w-full lg:w-1/2 px-4 py-2">
                @component('components.faq')
                    @slot('title')
                        Do you track pilot ids?
                    @endslot
                    @slot('body')
                        <p class="ml-1 mr-2 pt-2">
                            <b>No, absolutely not.</b> VatFlights as it stands currently, does not store any personally identifiable information about the pilot who has flown the flight.
                        </p>
                        <p class="ml-1 mr-2 pt-2">
                            We store airlines, callsigns and the flight associated with a callsign along with data about the flight such as its route, altitude, transponder, departure, arrival, aircraft type etc...
                        </p>
                    @endslot
                @endcomponent
                @component('components.faq')
                    @slot('title')
                        Why is the arrival field marked as ??? ?
                    @endslot
                    @slot('body')
                        <p class="ml-1 mr-2 pt-2">
                            The most popular arrival for the day is constantly calculated every 30 minutes based on data we get from the networks data file.
                            If there are no completed flights for that day, we are unable to calculate until such a flight or more is completed(arrived) at its destination.
                        </p>
                        <p class="ml-1 mr-2 pt-2">
                            <b>This is most likely to occur at the start of a new day.</b>
                        </p>
                    @endslot
                @endcomponent
                @component('components.faq')
                    @slot('title')
                        What timezone is the application using?
                    @endslot
                    @slot('body')
                        <p class="ml-1 mr-2 pt-2">
                            VatFlights operates on UTC/Zulu time the same as the rest of the aviation world.
                            Vatsim provides the timestamps in its metadata as Zulu. As such a new day will commence at midnight Zulu time.
                        </p>
                    @endslot
                @endcomponent
            </div>
        </div>
    </div>
</section>
