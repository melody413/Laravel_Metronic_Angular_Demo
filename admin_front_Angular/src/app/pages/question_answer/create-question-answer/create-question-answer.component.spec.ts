import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CreateQuestionAnswerComponent } from './create-question-answer.component';

describe('CreateQuestionAnswerComponent', () => {
  let component: CreateQuestionAnswerComponent;
  let fixture: ComponentFixture<CreateQuestionAnswerComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [CreateQuestionAnswerComponent]
    });
    fixture = TestBed.createComponent(CreateQuestionAnswerComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
