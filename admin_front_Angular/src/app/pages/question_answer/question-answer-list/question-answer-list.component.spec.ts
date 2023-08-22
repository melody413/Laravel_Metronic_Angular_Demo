import { ComponentFixture, TestBed } from '@angular/core/testing';

import { QuestionAnswerListComponent } from './question-answer-list.component';

describe('QuestionAnswerListComponent', () => {
  let component: QuestionAnswerListComponent;
  let fixture: ComponentFixture<QuestionAnswerListComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [QuestionAnswerListComponent]
    });
    fixture = TestBed.createComponent(QuestionAnswerListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
