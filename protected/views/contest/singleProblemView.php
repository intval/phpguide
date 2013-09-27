<?php /** @var $problem ContestProblem */ ?>
<div ng-controller="ContestCtrl">

    <h2><?=$problem->title?></h2>

    <?=$problem->text; ?>

    <h3>
    הדבק את הקוד שלך כאן:
    </h3>
    <br/>

    <div style='position:relative;height:205px; width:100%;direction:ltr;' dir="ltr">
            <div id='editor' style='position:absolute;width:100%; height:100%;font-size:16px;border:1px solid #0e90d2;'></div>
    </div>

    <?=CHtml::beginForm();?>
    <div style="margin:20px 0px 0 0 ;">
        <input ng-click="submitSolution(<?=e($problem->problemid)?>)" ng-disabled="submitInProgress"
               type="button" class="btn btn-primary btn-large" value="שלח פתרון"
               id="contestSolutionSubmitButton"/>
        <img src="http://s22.postimg.org/h7v8h5k8d/ajax_loader.gif" ng-show="submitInProgress" />
    </div>
    <?=CHtml::endForm();?>



    <div style="margin-top:30px;"></div>

    <script type="text/javascript">
        window.previousSubmits = <?=CJSON::encode($problem->userSubmits);?>;
    </script>

    <div ng-show="previousSubmits.length > 0" style="display:none">
        <h3>
        נסיונות קודמים:
        </h3>

        <br/>

        <div ng-repeat="submit in previousSubmits | reverse"
             class="well singleSubmitResult" dir="ltr">
            <b>#{{ $index+1 }}</b>
            <time class="timeago" datetime="{{ submit.date }}">{{ submit.date }}</time>
            <br/>
            {{ submit.result.error }}
        </div>


    </div>

</div>