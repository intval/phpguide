var ace_editor;

var contest =
{
    contestDiv: 'div[data-type="contestProblem"]',
    contestAnchor: 'a[rel="problemPage"]',

    goToProblem: function (clickEvent) {

        if(clickEvent.target.nodeName === 'a')
            return;

        var parentTarget = clickEvent.target.parent(this.contestDiv);
        console.log(parentTarget);

        var anchor = parentTarget.find(this.contestAnchor);
        console.log(anchor);
    },

    getCsrfToken: function()
    {
        return jQuery('input[name="YII_CSRF_TOKEN"]').val();
    }
};


jQuery(function(){
    jQuery(contest.contestDiv).click(contest.goToProblem);


    window.ace_editor = ace.edit("editor");
    var editor = window.ace_editor;

    editor.setTheme("ace/theme/chrome");
    editor.getSession().setMode("ace/mode/php");
    editor.setShowPrintMargin(false);
    editor.getSession().setUseWrapMode(true);

});


window.phpgAngularModule = window.phpgAngularModule || angular.module('phpg', []);

phpgAngularModule.filter('reverse', function() {
    return function(items) {
        if(!angular.isArray(items)) { return items; }
        return items.slice().reverse();
    };
});

phpgAngularModule.controller('ContestCtrl', function($scope) {
    $scope.previousSubmits = window.previousSubmits || [];
    $scope.submitInProgress = false;

    $scope.submitSolution = function(problemId)
    {
        var code = window.ace_editor.getSession().getValue().trim();
        if(code === '') return false;

        if(isguest)
        {
            unauth_message('contest');
            return false;
        }

        $scope.submitInProgress = true;
        jQuery.post
        (
            'contest/submitSolution/'+problemId,
            {code: code, 'YII_CSRF_TOKEN' : contest.getCsrfToken() },
            function(result)
            {
                $scope.$apply (function() {
                    $scope.previousSubmits.push(result);
                    $scope.submitInProgress = false;
                });
            },
            'json'
        );

        return true;
    }
});