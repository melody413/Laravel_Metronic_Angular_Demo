import { ComponentFixture, TestBed } from '@angular/core/testing';

import { EditQuestionAnswerComponent } from './edit-question-answer.component';

describe('EditQuestionAnswerComponent', () => {
  let component: EditQuestionAnswerComponent;
  let fixture: ComponentFixture<EditQuestionAnswerComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [EditQuestionAnswerComponent]
    });
    fixture = TestBed.createComponent(EditQuestionAnswerComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
