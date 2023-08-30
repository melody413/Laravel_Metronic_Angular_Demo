import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CreateFaqComponent } from './create-faq.component';

describe('CreateFaqComponent', () => {
  let component: CreateFaqComponent;
  let fixture: ComponentFixture<CreateFaqComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [CreateFaqComponent]
    });
    fixture = TestBed.createComponent(CreateFaqComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
