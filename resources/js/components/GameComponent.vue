<template>
    <div class="col-md-12" style="margin-bottom: 20px;">
        <!-- form card login with validation feedback -->
        <div class="card card-outline-secondary">
            <div class="card-header text-white" style="background-color: #00AA9E;">
                <h3 class="mb-0">Card Game</h3>
            </div>
            <div class="card-body">
                <form method="POST" role="form" autocomplete="off" action="/projects" @submit.prevent="onSubmit"
                      @keydown="form.errors.clear($event.target.name)">
                    <div class="form-group">
                            <span>
                                <b>Game rules:</b>
                                <ul style="margin-top: 10px;">
                                    <li>Enter your desired cards sequence. Each card should be separated by a space</li>
                                    <li>The system will generate the a random sequence of same size</li>
                                    <li>It will compare to the card in the same position. Highest value card wins. Good luck!</li>
                                </ul>
                            </span>
                        <label for="userCardSequence"></label>
                        <input type="text" class="form-control input" name="userCardSequence" id="userCardSequence"
                               required="required"
                               placeholder="Cards sequence"
                               autofocus v-model="form.userCardSequence">
                        <div class="alert alert-danger p-2 pb-3" v-if="form.errors.has('userCardSequence')"
                             v-text="form.errors.get('userCardSequence')">
                            <a class="close font-weight-normal initialism" data-dismiss="alert"
                               href="#"><samp>&times;</samp></a>
                        </div>
                        <div v-if="gameHasFinished && userHasWon && !form.errors.any()">
                            <div class="alert alert-success p-2 pb-5">
                                <a class="close font-weight-normal initialism" data-dismiss="alert" href="#"><samp>&times;</samp></a>
                                <h3>You Won!</h3><br>
                                <span style="padding-right: 16px;"> Player's hand: </span><b>{{userCardSequence.join(' ')}}</b> ({{gameScore.user}} points)<br>
                                <span> Generated hand: </span><b> {{cpuCardSequence.join(' ')}}</b> ({{gameScore.cpu}} points)
                            </div>
                        </div>
                        <div v-else-if="gameHasFinished && !userHasWon && !form.errors.any()">
                            <div class="alert alert-warning p-2 pb-5">
                                <a class="close font-weight-normal initialism" data-dismiss="alert" href="#"><samp>&times;</samp></a>
                                <h3>You lost.</h3><br>
                                <span style="padding-right: 16px;"> Player's hand: </span><b>{{userCardSequence.join(' ')}}</b> ({{gameScore.user}} points)<br>
                                <span> Generated hand: </span><b> {{cpuCardSequence.join(' ')}}</b> ({{gameScore.cpu}} points)
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success btn-lg float-right" id="btnLogin"
                            :disabled="form.errors.any()"> Play!
                    </button>
                </form>
            </div>
            <!--/card-body-->
        </div>
        <!-- /form card login -->
    </div>
</template>

<script>
    // Import the Form helper that will DRY up repetitive form interactions using an Object-Oriented Form
    import Form from "./Helpers/Form";

    export default {

        props: {
            user_id: {
                type: String,
                default() {
                    return ''
                }
            }
        },

        data: function () {
            return {
                userCardSequence: null,
                cpuCardSequence: null,
                userHasWon: null,
                gameScore: null,
                gameHasFinished: false,
                form: new Form({
                    userCardSequence: '',
                    userId: this.user_id,
                })
            }
        },

        methods: {
            // Fetch the game result and send a 'finished' event to the Event bus.
            onSubmit() {
                this.form.post('/api/v1/newgame')
                    .then(response => {
                        this.userCardSequence = response.data.userCardSequence;
                        this.cpuCardSequence = response.data.generatedCards;
                        this.userHasWon = response.data.gameScore.userIsWinner;
                        this.gameScore = response.data.gameScore;
                        this.gameHasFinished = true;
                        Event.fire('finished', response.data);
                    }).catch(error => {
                    // reset all data to prevent any undesired state.
                    this.userCardSequence = null;
                    this.cpuCardSequence = null;
                    this.userHasWon = null;
                    this.gameScore = null;
                    this.gameHasFinished = false;
                });
            }
        },
    }
</script>
