<script>
    export default {
        methods: {
            $is_admin() {
                let flag = false 
                if(this.$store.state.user.user_type == 1 ) {
                    flag = true
                }
                return flag
            },
        },
    }
</script>