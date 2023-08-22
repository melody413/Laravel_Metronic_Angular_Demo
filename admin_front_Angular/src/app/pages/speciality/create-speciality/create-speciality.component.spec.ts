import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CreateSpecialityComponent } from './create-speciality.component';

describe('CreateSpecialityComponent', () => {
  let component: CreateSpecialityComponent;
  let fixture: ComponentFixture<CreateSpecialityComponent>;

  beforeEach(() => {
    TestBed.configureTestingModule({
      declarations: [CreateSpecialityComponent]
    });
    fixture = TestBed.createComponent(CreateSpecialityComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
