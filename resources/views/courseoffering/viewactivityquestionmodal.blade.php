
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label class="col-form-label">Activity/Assesment</label>
            <select name="assesment_id" class="select" disabled>
                <option value="">- Select -</option>
                @foreach ($assesment as $a)
                    <option value="{{ $a->id }}" {{ $activity->assesment_id === $a->id ? 'selected' : '' }}  >{{ $a->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label class="col-form-label">Assesment Name</label>
            <input class="form-control" type="text" readonly value="{{ $activity->assesment_name }}" name="assesment_name">
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label class="col-form-label">Assesment Date</label>
            <input class="form-control" type="text"  readonly value="{{ $activity->assesment_date }}" name="assesment_date">
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label class="col-form-label">Assesment Total Mark</label>
            <input class="form-control" type="number"  readonly value="{{ $activity->assesment_total_mark }}" name="assesment_total_mark">
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label class="col-form-label">GPA Weight</label>
            <input class="form-control" type="number"  readonly value="{{ $activity->assesment_gpa_weight }}"  name="assesment_gpa_weight">
        </div>
    </div>
    <?php
    $chek = $activity->complex_engineering_problem ?? 'checked';
    $check = $activity->gpa_calculation ?? 'checked';
    ?>
    <div class="col-sm-3">
        <div class="form-group">
            <label class="col-form-label">Complex Engineering</label>
            <input class="form-control" type="checkbox"  readonly value="{{ $activity->complex_engineering_problem }}" {{$chek}} id="complex_engineering_problem" name="complex_engineering_problem">
        </div>
    </div>
    <div class="col-sm-3">  
        <div class="form-group">
            <label class="col-form-label">GPA Calculation</label>
            <input class="form-control" type="checkbox" id="gpa_calculation"  readonly value="{{ $activity->gpa_calculation }}" {{$check}}  name="gpa_calculation" checked>
        </div>
    </div>
</div>
<h4 class="modal-title">Sub Activity/Questions</h4>
<?php $i =1;?>
<?php foreach($activity->activityQuestions as $question){ ?>
    <?php 
    // echo "<pre>";
    // print_r($question->cloRecords);
    // die();
    ?>
    <h4 class="modal-title">Question # {{$i}} </h4>
    <div class="row">
        <div class="col-sm-6">  
            <div class="form-group">
                <label class="col-form-label">Name</label>
                <input class="form-control" type="text" readonly value="{{ $question->name }}" name="name">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-form-label">Correct Answer (Answer Guide) </label>
                <input class="form-control" type="text" readonly value="{{ $question->answer }}" name="answer">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-form-label">CLO</label>
                <select id="clo_id" name="clo_id" class="select" disabled multiple>
                <?php foreach($question->cloRecords as $clo){ ?>
                    <option value="{{$clo->id}}" selected>{{$clo->code}}</option>
                <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-form-label">Complexity </label>
                <select name="complexity" class="select" disabled>

                    <option value="1" {{ $question->question === "1" ? 'selected' : '' }}>Depth of knowledge required</option>
                    <option value="2" {{ $question->question === "2" ? 'selected' : '' }}>Range of conflicting requirements</option>
                    <option value="3" {{ $question->question === "3" ? 'selected' : '' }}>Depth of analysis required</option>
                    <option value="4" {{ $question->question === "4" ? 'selected' : '' }}>Familiarity of issues</option>
                    <option value="5" {{ $question->question === "5" ? 'selected' : '' }}>Extent of applicable codes</option>
                    <option value="6" {{ $question->question === "6" ? 'selected' : '' }}>Extent of stakeholder involvement and level of conflicting requiremen</option>
                    <option value="7" {{ $question->question === "7" ? 'selected' : '' }}>Interdependence</option>
                    <option value="8" {{ $question->question === "8" ? 'selected' : '' }}>Consequences</option>
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-form-label">Question Type</label>
                <select name="question" class="select" disabled>
                    <option value="T" {{ $question->question === "T" ? 'selected' : '' }}>Text Base</option>
                    <option value="R" {{ $question->question === "R" ? 'selected' : '' }}>Single Choice</option>
                    <option value="M" {{ $question->question === "M" ? 'selected' : '' }}>Multi Choice</option>
                    <option value="U" {{ $question->question === "U" ? 'selected' : '' }}>Attachment</option>
                </select>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-form-label">Max Marks</label>
                <input class="form-control" type="text" readonly value="{{ $question->max_mark }}" name="max_mark">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-form-label">% OBE Weight</label>
                <input class="form-control" type="text" readonly value="{{ $question->obe_weight }}" name="obe_weight">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-form-label">Question (Guidline for Question)</label>
                <textarea type="text" name="guidline" readonly class="form-control" placeholder="Enter Guidline">{{ $question->guidline}}</textarea>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="col-form-label">Choices (Choices Guide) (Set Choices)</label>
                <textarea type="text" name="choices" readonly class="form-control" placeholder="Enter Choices Guide">{{ $question->choices}}</textarea>
            </div>
        </div>
        <?php
            $chekd = $question->not_for_obe ?? 'checked';
        ?>
        <div class="col-sm-3">  
            <div class="form-group">
                <label class="col-form-label"> Not for OBE</label>
                <input class="form-control" id="not_for_obe" readonly type="checkbox" name="not_for_obe" {{$chekd}} value="{{ $question->not_for_obe }}" checked>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-xl-12">
            <label class="d-block"> Rubrics</label>
            <div class="form-group row" style="padding: 5px 0px 10px 18px;">
                <div class="col-lg-12">
                    <table class="table table-bordered target-table">
                        <thead>
                            <tr>
                                <th class="text-center">Cirteria </th>
                                <th class="text-center">Poor <br>0-1</th>
                                <th class="text-center">Unsatisfactory <br>1-2</th>
                                <th class="text-center">Satisfactory <br>2-3</th>
                                <th class="text-center">Very Satisfactory <br>3-4</th>
                                <th class="text-center">Outstanding <br>4-5</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($question->activityQuestionRubrics as $act){ ?>
                                
                                <tr>
                                    <td class="text-center"><textarea readonly style="width:125px;height:150px;" type="text"  class="form-control" name="question_complexity_scale_1_row_1">{{ $act->scale_1 }}</textarea></td>
                                    <td class="text-center"><textarea readonly style="width:125px;height:150px;" type="text"  class="form-control" name="question_complexity_scale_2_row_1">{{ $act->scale_2 }}</textarea></td>
                                    <td class="text-center"><textarea readonly style="width:125px;height:150px;" type="text"  class="form-control" name="question_complexity_scale_3_row_1">{{ $act->scale_3 }}</textarea></td>
                                    <td class="text-center"><textarea readonly style="width:125px;height:150px;" type="text"  class="form-control" name="question_complexity_scale_4_row_1">{{ $act->scale_4 }}</textarea></td>
                                    <td class="text-center"><textarea readonly style="width:125px;height:150px;" type="text"  class="form-control" name="question_complexity_scale_5_row_1">{{ $act->scale_5 }}</textarea></td>
                                    <td class="text-center"><textarea readonly style="width:125px;height:150px;" type="text"  class="form-control" name="question_complexity_scale_6_row_1">{{ $act->scale_6 }}</textarea></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php $i++; ?>
<?php } ?>