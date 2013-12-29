phpgAngularModule.controller "PostViewCtrl", ['$scope', '$http', 'phpgstate', ($scope, $http, phpgstate) ->

    $scope.hasAlreadyVoted = phpgstate.post.hasCurrentUserVoted
    $scope.postRating = phpgstate.post.rating

    $scope.vote = (direction) ->

        return if $scope.hasAlreadyVoted

        if direction is 'down' then rating = -1 else rating = 1

        $http.post("posts/changeRating/"+phpgstate.post.id,
            score: rating
        ).success((data) ->
            $scope.postRating = data
            $scope.hasAlreadyVoted = true
        )

]