<template>
    <div class="flex-none items-center ml-1">
        <i :class="classWhenUpvoted" @click="vote = 'upvote'; applyVote()" >keyboard_arrow_up</i>
        <span class="ml-2" v-text="votesCount"></span>
        <i :class="classWhenDownvoted" @click="vote = 'downvote'; applyVote()">keyboard_arrow_down</i>
    </div>
</template>

<script>
    import axios from 'axios'

    export default {
        props: ['data', 'model'],

        data() {
            return {
                votesCount: this.data.votesCount,
                isUpvoted: this.data.upvoted,
                isDownvoted: this.data.downvoted,
                vote: '',
            }
        },

        methods: {

            applyVote() {
                if(this.model === 'comment') {
                    if(this.vote === 'upvote') {
                        this.voteNow('/comment/' + this.data.id + '/vote', 'upvote', 'comment');
                    }else if(this.vote === 'downvote') {
                        this.voteNow('/comment/' + this.data.id + '/vote', 'downvote', 'comment');
                    }

                }else if(this.model === 'thread') {
                    // axios.post('/comment/' + this.model.id + '/vote');
                }
            },

            voteNow(uri, voteType, type) {
                axios.post(uri, {
                    model: type,
                    vote: voteType
                }).then(response => {
                    this.votesCount = response.data.count;
                    this.isUpvoted = response.data.isUpvoted;
                    this.isDownvoted = response.data.isDownvoted;
                });
            }

        },

        computed: {
            classWhenUpvoted() {
                return ['cursor-pointer', 'material-icons', this.isUpvoted ? 'text-blue-700' : ''];
            },

            classWhenDownvoted() {
                return ['cursor-pointer', 'material-icons', this.isDownvoted ? 'text-blue-700' : ''];
            }
        }
    }

</script>

