<template>
    <div class="col-md-12">
        <!-- form card login with validation feedback -->
        <div class="card card-outline-secondary">
            <div class="card-header">
                <h3 class="mb-0">Leaderboard</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover table-sm">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Played</th>
                        <th scope="col">Won</th>
                    </tr>
                    </thead>
                    <tbody v-if="hasUsers">
                    <tr v-bind:key="hasUsers.username"
                        v-bind:leaderboard="leaderboard" v-for="(userScore,index) in leaderboard">
                        <th scope="row">{{ index+1 }}&ordm;</th>
                        <td>{{ userScore.username}}</td>
                        <td>{{ userScore.played}}</td>
                        <td>{{ userScore.won}}</td>
                    </tr>
                    </tbody>
                    <tbody v-else>
                    <tr>
                        <td colspan="4" scope="col" class="text-center"> No data available</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!--/card-body-->
        </div>
        <!-- /form card login -->
    </div>
</template>

<script>

    export default {

        data: function () {
            return {
                leaderboard: []
            }
        },

        mounted() {
            // Save the scope to further usage
            let self = this;

            // Listen to game's ending and update the leaderboard with fresh API data.
            Event.listen('finished', function () {
                axios.get('/api/v1/leaderboard').then(({data}) => self.leaderboard = data.data);
            });
            // Fetches the initial data.
            axios.get('/api/v1/leaderboard').then(({data}) => this.leaderboard = data.data)
        },

        computed: {
            hasUsers: function () {
                return this.leaderboard.length > 0;
            }
        }
    }
</script>
