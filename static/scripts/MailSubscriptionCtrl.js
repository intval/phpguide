window.phpgAngularModule = window.phpgAngularModule || angular.module('phpg', ['ngResource'], function($httpProvider)
{
    // Use x-www-form-urlencoded Content-Type
    $httpProvider.defaults.headers.post['Content-Type'] = 'application/x-www-form-urlencoded;charset=utf-8';
    $httpProvider.defaults.headers.post['X-Requested-With'] = 'XMLHttpRequest';

    // Override $http service's default transformRequest
    $httpProvider.defaults.transformRequest = [function(data)
    {
        /**
         * The workhorse; converts an object to x-www-form-urlencoded serialization.
         * @param {Object} obj
         * @return {String}
         */
        var param = function(obj)
        {
            var query = '';
            var name, value, fullSubName, subName, subValue, innerObj, i;

            for(name in obj)
            {
                value = obj[name];

                if(value instanceof Array)
                {
                    for(i=0; i<value.length; ++i)
                    {
                        subValue = value[i];
                        fullSubName = name + '[' + i + ']';
                        innerObj = {};
                        innerObj[fullSubName] = subValue;
                        query += param(innerObj) + '&';
                    }
                }
                else if(value instanceof Object)
                {
                    for(subName in value)
                    {
                        subValue = value[subName];
                        fullSubName = name + '[' + subName + ']';
                        innerObj = {};
                        innerObj[fullSubName] = subValue;
                        query += param(innerObj) + '&';
                    }
                }
                else if(value !== undefined && value !== null)
                {
                    query += encodeURIComponent(name) + '=' + encodeURIComponent(value) + '&';
                }
            }

            return query.length ? query.substr(0, query.length - 1) : query;
        };

        return angular.isObject(data) && String(data) !== '[object File]' ? param(data) : data;
    }];
});


phpgAngularModule.controller('MailSubscriptionCtrl', function($scope, $http) {

    var cookieName = 'SubscribedToMails';

    $scope.email = '';
    $scope.name = '';
    $scope.csrf = '';
    $scope.isSubscribed = jQuery.cookie(cookieName);
    $scope.keyword = jQuery('meta[name="keywords"]').attr('content').split(',')[0];

    $scope.alertType = 'info';
    $scope.alertText = '';
    $scope.submitResulted = false;
    $scope.submitInProgress = false;

    $scope.subscribe = function(){
        if($scope.submitInProgress)
            return;
        setSubmitState('submitting', null);
    };

    function setSubmitState(state, data)
    {
        var alertType = 'info';
        var alertText = '';
        var submitInProgress = false;
        var submitResulted = false;

        switch(state)
        {
            case 'submitting':
                alertType = 'info';
                alertText = 'מנסה לרשום אותך לרשימה, רק רגע..';
                submitInProgress = true;
                submitResulted = false;
                submitSubscriptionForm();
                break;

            case 'done':
                if(data.status === true)
                {
                    alertType = 'success';
                    $scope.isSubscribed = jQuery.cookie(cookieName, $scope.email, { expires: 365 * 5 });
                    document.location = 'subscription/approve';
                }
                else
                {
                    alertType = 'error';
                }
                alertText = data.text;
                submitInProgress = false;
                submitResulted = true;
                break;

            case 'error':
                alertType = 'error';
                alertText = 'או, זה לא היה אמור לקרות, אבל יש בעיה כלשהי. אנא נסה שוב מאוחר יותר';
                submitInProgress = false;
                submitResulted = true;
                break;
        }

        $scope.alertType = alertType;
        $scope.alertText = alertText;
        $scope.submitInProgress = submitInProgress;
        $scope.submitResulted = submitResulted;
    }

    function submitSubscriptionForm()
    {

        $http.post
        (
            "/subscription/subscribe",
            {
                name: $scope.name,
                email: $scope.email,
                YII_CSRF_TOKEN: $scope.csrf
            }
        )
        .success(function (data, status, headers, config) {
                setSubmitState('done', data);
        })
        .error(function (data, status, headers, config) {
                setSubmitState('error', null);
        });
    }

});
